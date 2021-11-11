const host = window.location.origin;
getEquipments(host+'/api/equipments/type/pu');
async function getEquipments(url){
   
    try{
        const response = await fetch(url);

        const equipments = await response.json();
        console.log('from server');
        console.log(equipments);
        let content = document.querySelector('.content');
        equipments.forEach(equipment => {
            content.appendChild(equipmentContainerConstruct(equipment));
        });
        content.innerHTML += `<div>
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                            <div>
                                <label for="phone">Téléphone</label>
                                <input type="number" name="phone" id="phone">
                            </div>`;
        
       const devis = document.getElementById('devis');
       devis.addEventListener('click', function(){
            let devisData = validateData();
            console.log(devisData);
            showDevis(devisData);
            sendData(host+'/api/devis/link/construct', devisData);
       });
    }catch(error){
        console.error(error);
    }
}

function equipmentContainerConstruct(equipment){
    let container = document.createElement('div');
    let innerHTML = `<div>
                        <label for="${equipment.type}">${equipment.type}</label>
                        <input type="checkbox" name="equipments" value="${equipment.type}">
                    </div>
                    <div>
                        <label for="quantity-${equipment.type}">Nombre de ${equipment.type}</label>
                        <input type="number" name="quantity-${equipment.type}" id="quantity-${equipment.type}">
                    </div>
                    <input type="text" id="unit-price-${equipment.type}" value="${equipment.unit_price}" hidden> 
                    `;
    container.innerHTML = innerHTML;
    return container;
}

function validateData(){
    const sumbitEquipments = Array.from(document.querySelectorAll('input[name="equipments"]:checked'));
    let isValid = true
    if(sumbitEquipments.length == 0){
        alert('Vous devez choisir au moins un équipment');
        isValid = false;
        return;
    }
    let equipmentData = {};
    let total = 0;
    sumbitEquipments.forEach(checkbox => {
        const equipment = checkbox.value;
        console.log(equipment);
        const unitPrice = document.querySelector('#unit-price-'+equipment).value;
        const submitedQuantity = document.querySelector('#quantity-'+equipment).value;
        if(submitedQuantity == '' || submitedQuantity < 0){
            alert(`Vous devez saisir la quantité de l'équipment ${equipment} pour lequel vous souhitez recevoir un dévis`);
            return;
        }
        total += unitPrice * submitedQuantity;
        equipmentData[equipment] = {equipment : equipment, quantity: submitedQuantity, unitPrice};
        
    });
    const email = document.getElementById('email').value;
    if(!validateEmail(email)){
        isValid = false;
        return;
    }else {
        equipmentData['email']  = email;
    }
    const phone = document.getElementById('phone').value;
    if(!validatePhone(phone)){
        isValid = false;
        return;
    }else{
        equipmentData['phone']  = phone;
    }
    equipmentData['total']  = total;
    if(isValid){
        return equipmentData;
    }
    
}

function validateEmail(email){
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return true;
    }
    alert("Veuillez entrer un email valide")
    return false;
}
function validatePhone(phone) 
{
    if (/^7(7|8|0|6)|33\d{7}$/.test(phone)){
        return true;
    }
    alert("Veuillez entrer un numéro de téléphone valide")
    return false;
}

async function sendData(url, data){
    
    // console.log(JSON.stringify(data));
    try{
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const dataServer = await response.json();
        console.log('from server senddata');
        console.log(dataServer);

       
    }catch(error){
        console.error(error);
    }
}

function showDevis(equiments){
    let total = 0;
    let resume = document.querySelector('.resume-detail')
    resume.innerHTML = '';
    let table = document.createElement('table');
    let thead = document.createElement('thead');
    let tr = document.createElement('tr');
    const ths = ['Type Equipement', 'Quantité', 'Prix Unitaire', 'Total'];
    ths.forEach(th => {
            let thCel = document.createElement('th');
            thCel.innerHTML = th ;
            tr.appendChild(thCel);
    });
    thead.appendChild(tr);
    table.appendChild(thead);
    let tbody = document.createElement('tbody');
    for (let [key, value] of Object.entries(equiments)) {
        
        if(key !== 'email' && key !== 'phone' && key !== 'total') {
            console.log(value);

            let tr = document.createElement('tr');
            let tdType = document.createElement('td');
            tdType.innerHTML = value.equipment;
            tr.appendChild(tdType);
                    
            let tdQuantity = document.createElement('td');
            tdQuantity.innerHTML = value.quantity;
            tr.appendChild(tdQuantity);

            let tdPU = document.createElement('td');
            tdPU.innerHTML = value.unitPrice;
            tr.appendChild(tdPU);

            let tdPT = document.createElement('td');
            const totalPrice = value.unitPrice * value.quantity;
            tdPT.innerHTML = totalPrice;
            tr.appendChild(tdPT);
            total += totalPrice;

            tbody.appendChild(tr);

            
        }
        
        
    }
    table.appendChild(tbody);
        // dayDiv.appendChild(table);
    resume.appendChild(table);
    let totalDiv = document.createElement('div');
    totalDiv.innerHTML = `Total du devis : <strong>${total}</strong>`;
    resume.appendChild(totalDiv);
}
