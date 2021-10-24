const details = Array.from(document.querySelectorAll('.detail'));
let page = document.querySelector('.page');
const renteds = Array.from(document.querySelectorAll('.rent'));
const bookeds = Array.from(document.querySelectorAll('.book'));
const rentsButton = document.getElementById('rents');
// debut voir détail
details.forEach(detail => {
    detail.addEventListener('click', e => {
        e.preventDefault();
        let container = document.querySelector('.detail-equipment-container');
        // Si on a déja afficher un détail sur un équipement, on le supprime 
        if(container){
            page.removeChild(container);
        }
        fetch(`http://127.0.0.1:8000/api/equipments/${detail.id}`)
            .then(response => response.json())
            .then(data => {
                const equipment = data[0];
                const printableInfos = data[1];
                const images = data[2];
                container = document.createElement('div');
                container.classList.add('detail-equipment-container');
                let equipmentDetail = document.createElement('div');
                equipmentDetail.classList.add('equipment-detail');
                printableInfos.forEach(item => {
                    let itemElement = document.createElement('div');
                    itemElement.classList.add('item-detail');
                    if(item === 'type'){
                        itemElement.innerHTML = `Tyte Equipement : <strong>${equipment.type}</strong>`
                    }else if(item === 'quantity'){
                        itemElement.innerHTML = `Quantité disponible : <strong>${detail.getAttribute('data-quantity')}</strong>`
                    }else if(item === 'description'){
                        itemElement.innerHTML = `<strong>Description</strong> : <p>${equipment.description}</p>`
                    }
                    equipmentDetail.appendChild(itemElement);
                });
                container.appendChild(equipmentDetail);
                let imagesContainer = document.createElement('equipment-images');
                images.forEach(image => {
                    let img = document.createElement('img');
                    img.alt = image.alt;
                    img.src = `/storage/equipment-images/${image.url}` ; 
                    img.classList.add('item-image');
                    imagesContainer.appendChild(img);         
                });

                container.appendChild(imagesContainer);
                container.addEventListener('click', e => {
                        page.removeChild(container);
                });
                page.appendChild(container);
            });
           
       
    });
});
// fin voir détail

// debut Locations
renteds.forEach(rent => {
    rent.addEventListener('click', e => {
        e.preventDefault();
        const oldContainerDiv = document.querySelector('.rent-book');
        
        if(oldContainerDiv){
            oldContainerDiv.parentNode.removeChild(oldContainerDiv);
        }
        let containerDiv = document.createElement('div');
        containerDiv.classList.add('rent-book');
        let parent = rent.parentNode;
        let equipmentDiv = document.createElement('div');
        
        let previousEquipment = parent.previousElementSibling;
        do {
            const type = previousEquipment.getAttribute('data-type-equipment');
            const availableQuantity = previousEquipment.getAttribute('quantity-available');
            
            let checkboxDiv = ` <div class="checkbox">
                                <div hidden class="${type}">${availableQuantity}</div>
                                <div>
                                    <label for="equipment">${type}</label>
                                    <input type="checkbox" value="${type}" name="type">
                                    
                                </div>
                                <div>
                                    <label for="equipment">Quantité</label>
                                    <input type="number" id="${type}"  min="1" max="${availableQuantity}">
                                    
                                </div>
                            </div>`;
        
        equipmentDiv.innerHTML += checkboxDiv ;
        previousEquipment.appendChild(containerDiv);
        previousEquipment = previousEquipment.previousElementSibling;
        } while (previousEquipment);

        // let dateStart = ` <div class="start-date">
        //                     <label for="start-date">Début Location</label>
        //                     <input type="date" name="start-date" id="start-date">
        //                 </div>`;
        // equipmentDiv.innerHTML += dateStart ;
        // let dateEnd = ` <div class="end-date">
        //                     <label for="end-date">Fin de location</label>
        //                     <input type="date" name="end-date" id="end-date">
        //                 </div>`;
        // equipmentDiv.innerHTML += dateEnd ;                
        let submit = ` <div class="submit-container">

                            <input type="submit" name="rent" value="Louer" id="rent-booked">
                        </div>`;
        equipmentDiv.innerHTML += submit ;

        containerDiv.appendChild(equipmentDiv);

        const submitInput = document.getElementById('rent-booked');
        submitInput.addEventListener('click', e => {
            const data = validateData();
            if(data == false){
                return;
            }else{
                let divResume = document.createElement('div');
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
                for (let [key, item] of Object.entries(JSON.parse(data.equipmentData))) {
               
                    // item = JSON.parse(item);
                    let tr = document.createElement('tr');
                    let tdType = document.createElement('td');
                    tdType.innerHTML = item.equipment;
                    tr.appendChild(tdType);
                    
                    let tdQuantity = document.createElement('td');
                    tdQuantity.innerHTML = item.quantity;
                    tr.appendChild(tdQuantity);

                    let tdPU = document.createElement('td');
                    tdPU.innerHTML = '1200'
                    tr.appendChild(tdPU);

                    let tdPT = document.createElement('td');
                    tdPT.innerHTML = '1250000';
                    tr.appendChild(tdPT);

                    tbody.appendChild(tr);
                
                }
                table.appendChild(tbody);
                divResume.appendChild(table);
                divResume.classList.add('resume');
                let emailContainer = document.createElement('div');
                let emailLabel = document.createElement('label');
                emailLabel.innerHTML = 'votre email';
                emailContainer.appendChild(emailLabel);

                let email = document.createElement('input');
                email.type = 'text';
                email.id = "email";
                email.placeholder = 'exemple@gmail.com';
                emailContainer.appendChild(email);
                divResume.appendChild(emailContainer);

                let phoneContainer = document.createElement('div');
                let phoneLabel = document.createElement('label');
                phoneLabel.innerHTML = 'votre numéro';
                phoneContainer.appendChild(phoneLabel);

                let phone = document.createElement('input');
                phone.type = 'text';
                phone.placeholder = '774521020';
                phone.id = 'phone';
                phoneContainer.appendChild(phone);
                divResume.appendChild(phoneContainer);

                let confirmButton = document.createElement('input');
                confirmButton.type = 'submit';
                confirmButton.value = 'Confirmer la réservation';
                confirmButton.id = 'confirm-button';
                divResume.appendChild(confirmButton);
                let closeDivResume = document.createElement('div');
                closeDivResume.innerHTML = 'Ferme';
                closeDivResume.classList.add('close-div-resume');
                divResume.appendChild(closeDivResume);
                let page = document.querySelector('.page');
                page.appendChild(divResume);

                closeDivResume.addEventListener('click', e => {
                    divResume.parentElement.removeChild(divResume);
                });

                confirmButton.addEventListener('click', e => {
                    const email = document.getElementById('email').value;
                    const phone = document.getElementById('phone').value;
                    if(validateEmail(email)){
                        data.email = email;
                    }else{
                        return;
                    }
                    if(validatePhone(phone)){
                        data.phone = phone;
                    }else{
                        return;
                    }
                    
                    sendData('http://127.0.0.1:8000/api/rent/equipments', data);
                });

                
                
            }
        });


        

    });
});

rentsButton.addEventListener('click', e => {
    renteds.forEach(rent => {
        rent.style.display = 'block';
    });
});
// finS Locations

// Functions
function dateCompare(dateOne, dateTwo) {

    if (dateOne < dateTwo) {
        return false;
    }
    return true;
}

function validateData(){
    const sumbitEquipments = Array.from(document.querySelectorAll('input[name="type"]:checked'));
    if(sumbitEquipments.length == 0){
        alert('Vous devez choisir au moins un équipment à Louer ou réserver');
        return;
    }
    const startDateInput = document.getElementById('start-date');
    const startDate = startDateInput.value;
    const endDateInput = document.getElementById('end-date');
    const endDate = endDateInput.value;
    if(startDate === '' || endDate === ''){
        alert('Les dates de début et de fin sont obligatoire');
        return;
    }
    if(dateCompare(new Date(), new Date(startDate))){
        alert("La date de début de réservation ne peut pas être inférieur à celle d'aujourd'hui");
        return ;
    }
    if(dateCompare(new Date(), new Date(endDate))){
        alert("La date de fin de réservation ne peut pas être inférieur à celle de d'aujourd'hui");
        return ;
    }
    if(dateCompare(new Date(startDate), new Date(endDate))){
        alert('La date de fin de réservation ne peut pas être inférieur à celle de début');
        return ;
    }
    
    
    let equipmentData = {};
    sumbitEquipments.forEach(checkbox => {
        const equipment = checkbox.value
        const availableQuantity = document.querySelector('.'+equipment).innerHTML;
        const submitedQuantity = document.querySelector('#'+equipment).value;
        if(parseInt(submitedQuantity) < 1 || parseInt(submitedQuantity) > availableQuantity || submitedQuantity == ''){
            alert(`La quantité à réserver pour les ${equipment}s doit être comprise entre 1 et ${availableQuantity}`);
            return;
        }
        equipmentData[equipment] = {equipment : equipment, quantity: submitedQuantity};
        
    });

    

       let data = {
            equipmentData: JSON.stringify(equipmentData),
            startDate,
            endDate

       }
       
       return data;
    
}

async function sendData(url, data){
    console.log('in senddat strinfy data');
    console.log(JSON.stringify(data));
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
        console.log(dataServer.success);

       
    }catch(error){
        console.error(error);
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


