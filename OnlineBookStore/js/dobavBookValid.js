const form = document.getElementById('form');
const nameBook = document.getElementById('name');
const category = document.getElementById('category');
const author = document.getElementById('author');
const year = document.getElementById('year');
const volume = document.getElementById('volume');
const vozrast = document.getElementById('vozrast');
const price = document.getElementById('price');
const image = document.getElementById('image');
const href = document.getElementById('href');
const descrip = document.getElementById('descrip');

form.addEventListener('submit', e => {
	e.preventDefault();
	
	checkInputs();
});

function checkInputs() 
{
	// trim чтобы убрать пробелы

	const nameValue = nameBook.value.trim();
	const categoryValue = category.value.trim();
	const authorValue = author.value.trim();
	const yearValue = year.value.trim();
    const volumeValue = volume.value.trim();
	const vozrastValue = vozrast.value.trim();
	const priceValue = price.value.trim();
	const imageValue = image.value.trim();
    const hrefValue = href.value.trim();
	const descripValue = descrip.value.trim();

    if(nameValue === '') {
		setErrorFor(nameBook, 'Укажите название книги');
	} else if (!isText(nameValue)) {
		setErrorFor(nameBook, 'Неверный формат названия книги');
	} else {
		setSuccessFor(nameBook);
	}
	
	if(categoryValue === '') {
		setErrorFor(category, 'Укажите жанр');
	} else if (!isText(categoryValue)) {
		setErrorFor(category, 'Неверный формат жанра');
	} else {
		setSuccessFor(category);
	}
}

function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    // formControl.className = 'form-control error';
    small.innerText = message;
}

function setSuccessFor(input) {
    const formControl = input.parentElement;
    // formControl.className = 'form-control success';
}
    
function isText(nameBook) {
    return /^[а-яА-ЯёЁa-zA-Z0-9\s]+$/.test(nameBook);
}