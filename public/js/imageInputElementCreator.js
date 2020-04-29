var counter = -1;
var maxImages = 5;

document.body.onload = function() {
        addImageInput()
    };

function addImageInput()
{
    counter++
    var id = `image${counter.toString()}`

    var newInput = document.createElement("input");
    newInput.setAttribute("id", id);
    newInput.setAttribute("type", "file");
    newInput.setAttribute("accept", "image/*");
    newInput.setAttribute("name", id);
    newInput.setAttribute("placeholder", "Image file");
    newInput.setAttribute("onChange", "checkAddImageInputEnabled()");


    document.getElementById('image-upload').appendChild(newInput);

    checkAddImageInputEnabled();
}

function checkAddImageInputEnabled()
{
    if(document.getElementById(`image${counter.toString()}`).files.length > 0
    && counter < maxImages)
    {
        addImageInput();
    }
}

function removeElementById(id)
{
    document.getElementById(id).remove();
}
