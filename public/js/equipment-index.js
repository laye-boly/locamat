const host = window.location.origin;
async function deleteEquipment(url, data = {}){

    try{
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
                },
            body: JSON.stringify(data)
        });
    
        const updatedEquipment = await response.json();
        const equipmentContainer = document.querySelector('.content tbody');
        const equipmentChildren = Array.from(equipmentContainer.children);
        equipmentContainer.innerHTML = '';
        equipmentChildren
            .filter(child => !child.classList.contains(`equipment-no-${data['equipment-id']}`))
            .forEach(child => equipmentContainer.appendChild(child));
           
        }catch(error){
            console.error(error);
        }
 
        
        const successDiv = document.querySelector('.success-bg');
        successDiv.style.display = 'block';
        const closeSuccessDiv = document.querySelector('#close-div');
        closeSuccessDiv.addEventListener('click', () => {
            successDiv.style.display = 'none';
        });

    
}

const formEquipmentDelete = Array.from(document.querySelectorAll('.form-equipment-delete'));
formEquipmentDelete.forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const dataNodes = Array.from(e.target.children).filter(node => {
            console.log(node);
            if(node.nodeName == 'INPUT' && (node.getAttribute('name').includes('equipment-id') || node.getAttribute('name').includes('_token'))){
                return true;
            }
        });
        let data = {};
        dataNodes.forEach(dataNode => {
            data[dataNode.getAttribute('name')] = dataNode.value;
        } );

        const url = `${window.location.host}/image/delete`;
        console.log(url)
        deleteEquipment(host+'/api/equipment/delete', data);
    });
});