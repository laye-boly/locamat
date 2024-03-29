const details = Array.from(document.querySelectorAll('.detail'));
let page = document.querySelector('.page');
const renteds = Array.from(document.querySelectorAll('.rent'));
const bookeds = Array.from(document.querySelectorAll('.book'));
const host = window.location.origin;

let allSubmitedEquipment = {}; 

// debut voir détail
details.forEach(detail => {
    detail.addEventListener('click', e => {
        e.preventDefault();
        let container = document.querySelector('.detail-equipment-container');
        // Si on a déja afficher un détail sur un équipement, on le supprime 
        if(container){
            page.removeChild(container);
        }
        fetch(`${host}/api/equipments/${detail.id}`)
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
        let dayDate = rent.parentElement.parentElement.previousElementSibling.innerHTML.trim();
        dayDate = stringToDate(dayDate);
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
            const unitPrice = previousEquipment.getAttribute('unit-price');
            
            let checkboxDiv = ` <div class="checkbox">
                                <div hidden class="${type}">${availableQuantity}</div>
                                <div hidden class="${type}-unit-price">${unitPrice}</div>
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
               
        let submit = ` <div class="submit-container">

                            <input type="submit" name="rent" value="Louer" id="rent-booked">
                        </div>`;
        equipmentDiv.innerHTML += submit ;

        containerDiv.appendChild(equipmentDiv);

        const submitInput = document.getElementById('rent-booked');
        submitInput.addEventListener('click', e => {
            console.log('clicked');
            // equipmentData[equipment] = { : equipment, quantity: submitedQuantity, unitPrice};
            const dayReservation = validateData();
            if(dayReservation == undefined){
                return;
            }
            allSubmitedEquipment[dayDate] = JSON.stringify(dayReservation);
            console.log(allSubmitedEquipment);  
            containerDiv.parentNode.removeChild(containerDiv); 
            showSubmitedEquipmentDetail(allSubmitedEquipment) ;
            const validateButton = document.querySelector('.validate');
            validateButton.addEventListener('click', e => {
                console.log(validateButton);
                const phoneValue = document.querySelector('#phone').value;
                if(validatePhone(phoneValue) == false){
                    return;
                }
                allSubmitedEquipment.phone = phoneValue;
                const emailValue = document.querySelector('#email').value;
                if(validateEmail(emailValue) == false){
                    return;
                }

                allSubmitedEquipment.email = emailValue;

                const orderType = document.querySelector('input[name="order_type"]:checked').value;
                allSubmitedEquipment.orderType = orderType;
                sendData('http://127.0.0.1:8000/api/rent/equipments', allSubmitedEquipment);
            });
        });  

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
    let isValid = true
    if(sumbitEquipments.length == 0){
        alert('Vous devez choisir au moins un équipment à Louer ou réserver');
        isValid = false;
        return;
    }
    let equipmentData = {};
    sumbitEquipments.forEach(checkbox => {
        const equipment = checkbox.value
        const availableQuantity = document.querySelector('.'+equipment).innerHTML;
        const unitPrice = document.querySelector('.'+equipment+'-unit-price').innerHTML;
        const submitedQuantity = document.querySelector('#'+equipment).value;
        if(parseInt(submitedQuantity) < 1 || parseInt(submitedQuantity) > availableQuantity || submitedQuantity == ''){
            alert(`La quantité à réserver pour les ${equipment}s doit être comprise entre 1 et ${availableQuantity}`);
            isValid = false;
            return;
        }
        equipmentData[equipment] = {equipment : equipment, quantity: submitedQuantity, unitPrice};
        
    });
    if(isValid){
        return equipmentData;
    }
    
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
        console.log('from server');
        console.log(dataServer);

       
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

function stringToDate(stringDate){
    dateArray = stringDate.split(' ');
    console.log(dateArray);
    day = dateArray[1];
    year = dateArray[3];
    stringMonth = dateArray[2];
    month = '01';
    switch (stringMonth) {
        case 'janvier':
            month = '01';
            break;
        case 'février':
            month = '02';
            break;
        case 'mars':
            month = '03';
            break;
        case 'avril':
            month = '04';
            break;
        case 'mai':
            month = '05';
            break;
        case 'juin':
            month = '06';
            break;
        case 'juilliet':
            month = '07';
            break;
        case 'août':
            month = '08';
            break;
        case 'septembre':
            month = '09';
            break;
        case 'octobre':
            month = '10';
            break;
        case 'novembre':
            month = '11';
            break;
        case 'décembre':
            month = '12';
            break;
            
    }

    return year+'-'+month+'-'+day;
}

function showSubmitedEquipmentDetail(equiments){
    let resume = document.querySelector('.resume-detail')
    resume.innerHTML = '';
    for (let [day, values] of Object.entries(equiments)) {
        
        let dayDiv = document.createElement('div');
        dayDiv.classList.add('day-rent-book');
        let title = document.createElement('h3');
        title.innerHTML = day;
        dayDiv.appendChild(title);

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
        
        for (let [key, item] of Object.entries(JSON.parse(values))) {
            let tr = document.createElement('tr');
            let tdType = document.createElement('td');
            tdType.innerHTML = item.equipment;
            tr.appendChild(tdType);
                    
            let tdQuantity = document.createElement('td');
            tdQuantity.innerHTML = item.quantity;
            tr.appendChild(tdQuantity);

            let tdPU = document.createElement('td');
            tdPU.innerHTML = item.unitPrice;
            tr.appendChild(tdPU);

            let tdPT = document.createElement('td');
            const totalPrice = item.unitPrice * item.quantity;
            tdPT.innerHTML = totalPrice;
            tr.appendChild(tdPT);

            tbody.appendChild(tr);

            
        }
        table.appendChild(tbody);
        dayDiv.appendChild(table);
        resume.appendChild(dayDiv);
        
    }

    let emailContainer = document.createElement('div');
    let emailLabel = document.createElement('label');
    emailLabel.innerHTML = 'votre email';
    emailContainer.appendChild(emailLabel);

    let email = document.createElement('input');
    email.type = 'text';
    email.id = "email";
    email.placeholder = 'exemple@gmail.com';
    emailContainer.appendChild(email);
    resume.appendChild(emailContainer);

    let phoneContainer = document.createElement('div');
    let phoneLabel = document.createElement('label');
    phoneLabel.innerHTML = 'votre numéro';
    phoneContainer.appendChild(phoneLabel);

    let phone = document.createElement('input');
    phone.type = 'text';
    phone.placeholder = '774521020';
    phone.id = 'phone';
    phoneContainer.appendChild(phone);
    resume.appendChild(phoneContainer);

    let typeOrderContainer = document.createElement('div');
    let typeOrdeLabel = document.createElement('div');
    typeOrdeLabel.innerHTML = 'Type de la commande';
    typeOrderContainer.appendChild(typeOrdeLabel);


    let rentalType = document.createElement('div');
    rentalType.innerHTML = 'Location';
    

    let rentalInput = document.createElement('input');
    rentalInput.type = 'radio';
    rentalInput.id = "rental-input";
    rentalInput.name = 'order_type';
    rentalInput.checked = 'checked';
    rentalInput.value = 'rent';
    rentalType.appendChild(rentalInput);
    typeOrderContainer.appendChild(rentalType);

    let reservationType = document.createElement('div');
    reservationType.innerHTML = 'Reservation';

    let reservationInput = document.createElement('input');
    reservationInput.type = 'radio';
    reservationInput.id = "reservation-input";
    reservationInput.name = 'order_type';
    reservationInput.value = 'booked';
    reservationType.appendChild(reservationInput);
    typeOrderContainer.appendChild(reservationType);

    resume.appendChild(typeOrderContainer);

    validateButton = document.createElement('button');
    validateButton.classList.add('validate');
    validateButton.textContent = 'Valider la location';
    resume.appendChild(validateButton);
}




