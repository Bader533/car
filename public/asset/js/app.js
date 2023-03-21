let files = [],
button = document.querySelector(".top button"),
form = document.querySelector("form"),
container = document.querySelector(".container");
text = document.querySelector(".inner");
browse = document.querySelector(".select");
input = document.querySelector(".file");
let image_url = [];
let images = [];

browse.addEventListener("click", () => input.click());

input.addEventListener("change", () => {
    let file = input.files;
    for (let i = 0; i < file.length; i++) {
        if (files.every((e) => e.name != file[i].name)) files.push(file[i]);
        image_url.push(file[i].name);
        images.push(file[i]);
    }
    // form.reset();
    showImages();
});

const showImages = () => {
    let images = "";
    files.forEach((e, i) => {
        images += `<div class="image">
                    <img src="${URL.createObjectURL(e)}" alt="image">
                    <span onclick="delImage(${i})">&times;</span>
                </div>`;
    });
    container.innerHTML = images;
};

const delImage = (index) => {
    delete files[index];
    image_url.splice(index);
    // console.log(files[0].name);
    console.log(index);
    showImages();
};

form.addEventListener("dragover", (e) => {
    e.preventDefault();
    form.classList.add("dragover");
    text.innerHTML = "drop images here";
});

form.addEventListener("dragover", (e) => {
    e.preventDefault();
    form.classList.remove("dragover");
    text.innerHTML =
        ' Drag & drop image here or <span class="select" role="button">Browse</span>';
});

form.addEventListener("drop", (e) => {
    e.preventDefault();
    form.classList.remove("dragover");
    text.innerHTML =
        ' Drag & drop image here or <span class="select" role="button">Browse</span>';
    let file = e.dataTransfer.files;
    for (let i = 0; i < file.length; i++) {
        if (files.every((e) => e.name != file[i].name)) files.push(file[i]);
    }
    showImages();
});

// button.addEventListener("click", () => {
//     let form = new FormData();
//     files.forEach((e, i) => form.append(`file[${i}]`, e));
// });

function updateCar(id) {
    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('owner_id',document.getElementById('owner_id').value);
    formData.append('car_name', document.getElementById('car_name').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('fuel_type', document.getElementById('fuel_type').value);
    formData.append('car_type', document.getElementById('car_type').value);
    formData.append('description',document.getElementById('description').value);
    formData.append('city',document.getElementById('city').value);
    formData.append('car_image', image_url);
    for (const image of images) {
        formData.append("images[]",image);
    }
    // formData.append('images', images);
    update('/car/'+id, formData,'/car');
}

function update(url, data, redirectRoute) {
    console.log(data);
    axios.post(url, data)
        .then(function (response) {
            // handle success 2xx
            console.log(response);
            if (redirectRoute != undefined) {
                window.location.href = redirectRoute;
            } else {
                toastr.success(response.data.message);
            }
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            toastr.error(error.response.data.message);
        });
}


function performDelete(id) {
    axios
        .delete("/image/delete/" + id)
        .then(function (response) {
            //2xx
            console.log(response);
            $(".container").load(window.location.href + " .container");
        })
        .catch(function (error) {
            //4xx - 5xx
            console.log(error.response.data.message);
        });
}
