console.log("hi");

async function deleteImage(url, data = {}){
    const imagesNumberDiv = document.getElementById('images-number');
    let imagesNumber = parseInt(imagesNumberDiv.innerHTML);
    if(imagesNumber > 1){
        try{
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
    
            const updatedImages = await response.json();
            const imageContainer = document.querySelector('.equipment-images');
            const imagesChildren = Array.from(imageContainer.children);
            console.log(imagesChildren);
            imageContainer.innerHTML = '';
            imagesChildren
                .filter(child => child.classList.contains(`image-no-${data['image-id']}`))
                .forEach(child => imageContainer.appendChild(child));
            
            
            imagesNumber--;
            imagesNumberDiv.innerHTML = imagesNumber;
           
        }catch(error){
            console.error(error);
        }
    }else{
        console.log('iii');
        const warningDiv = document.querySelector('.warning-bg');
        warningDiv.style.display = 'block';
        const closeWarningDiv = document.querySelector('#close-div');
        closeWarningDiv.addEventListener('click', () => {
            warningDiv.style.display = 'none';
        });

    }
}

const formImageDelete = Array.from(document.querySelectorAll('.form-image-delete'));
formImageDelete.forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log(e.target);
        const dataNodes = Array.from(e.target.children).filter(node => {
            if(node.nodeName == 'INPUT' && (node.getAttribute('name').includes('image-id') || node.getAttribute('name').includes('_token'))){
                return true;
            }
        });
        let data = {};
        dataNodes.forEach(dataNode => {
            data[dataNode.getAttribute('name')] = dataNode.value;
        } );

        const url = `${window.location.host}/image/delete`;
        console.log(url)
        deleteImage('http://127.0.0.1:8000/image/delete', data);
    });
});