
// Load the right cabin images based on bedrooms number

const bookingsDiv = document.querySelector('#bookingDisplay').querySelectorAll('div[id]');

window.addEventListener('load', () => {
    bookingsDiv.forEach((div) => {
        const bedroomNumber = div.querySelector('#bedroom').textContent[0]
        div.querySelector('img').setAttribute('src', `/images/${bedroomNumber}rooms.png`)
    });
});

// FUNCTIONS ----------------------------------------------------------------------------------------------------------------------------------------//

// Function format date(week) from "2024-W05" to "Du 29/01/2024 au 04/02/2024"

function formatWeekPicker(inputWeek) {
    const year = inputWeek.substring(0, 4);
    const week = inputWeek.substring(6);

    const date = new Date(year, 0, (week -1) * 7 + 1);
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };

    const startDate = date.toLocaleDateString('fr-FR', options);
    const endDate = new Date(date.setDate(date.getDate() + 6)).toLocaleDateString('fr-FR', options);
    return`Du ${startDate} au ${endDate}`;
}

// Functions to create bookings

function createNode(element) {
    return document.createElement(element);
}

function append(parent, child) {
    return parent.appendChild(child);
}

// Function create div (booking)

const bookingContainer = document.querySelector('#bookingDisplay'); // The div that contains all bookings

function createBooking(cabinName, bedroom, week) {
    const divReference = generateRandomHex()
    const divContainer = createNode('div')
    divContainer.setAttribute('class', 'row m-4 border shadow rounded-3 res-row')
    divContainer.setAttribute('id', `div${divReference}`)

    const divLeft = createNode('div')
    divLeft.setAttribute('class', 'col-6')

    const img = createNode('img')
    img.setAttribute('class', 'shadow cabin-img')
    img.setAttribute('src', `/images/${bedroom}rooms.png`)

    const divRight = createNode('div')
    divRight.setAttribute('class', 'col res-content my-4')

    const divText = createNode('div')

    const h5 = createNode('h5')
    h5.setAttribute('class', 'cabin-name mb-3')
    h5.textContent = cabinName

    const spanRef1 = createNode('span')
    spanRef1.textContent = 'Référence : '

    const spanRef2 = createNode('span')
    spanRef2.setAttribute('class', 'fw-bold text-success')
    spanRef2.setAttribute('id', 'reference')
    spanRef2.textContent = divReference

    const br1 = createNode('br')

    const span = createNode('span')
    span.setAttribute('id', 'bedroom')
    span.textContent = `${bedroom} chambre(s)`

    const br2 = createNode('br')


    const small = createNode('small')
    small.setAttribute('class', 'week')
    small.setAttribute('id', 'week')
    small.setAttribute('value', `${week}`)
    small.textContent = formatWeekPicker(week)

    const divButtons = createNode('div')

    const btnModif = createNode('button')
    btnModif.setAttribute('class', 'btn btn-sm  mt-3 bt-classic')
    btnModif.setAttribute('type', 'button')
    btnModif.setAttribute('data-bs-toggle', 'modal')
    btnModif.setAttribute('data-bs-target', '#modifyModal')
    btnModif.textContent = 'MODIFIER'
    
    const btnDel = createNode('button')
    btnDel.setAttribute('class', 'btn btn-sm  mt-3 ms-1 bt-other')
    btnDel.setAttribute('type', 'button')
    btnDel.setAttribute('data-bs-toggle', 'modal')
    btnDel.setAttribute('data-bs-target', '#deleteModal')
    btnDel.textContent = 'SUPPRIMER'

    append(divLeft, img)
    append(divContainer, divLeft)

    append(divText, h5)
    append(divText, spanRef1)
    append(divText, spanRef2)
    append(divText, br1)
    append(divText, span)
    append(divText, br2)
    append(divText, small)
    append(divRight, divText)

    append(divButtons, btnModif)
    append(divButtons, btnDel)
    append(divRight, divButtons)
    append(divContainer, divRight)

    append(bookingContainer, divContainer)
}


// Function create random booking reference

function generateRandomHex(length = 12) {
    const characters = '0123456789abcdef';
    const randomValues = new Uint8Array(length);
    crypto.getRandomValues(randomValues);

    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters[randomValues[i] % characters.length];
    }
    return result;
}


//------------------------------------------------------------------------------------------------------------------------------------------//

// Delete booking Modal
const deleteModal = document.getElementById('deleteModal');
const updateModal = document.getElementById('modifyModal');

function loadModal(modalType) {
    if (modalType) {
        modalType.addEventListener('show.bs.modal', e => {
            const button = e.relatedTarget

            switch (modalType) {

                case deleteModal:
                    const deleteBooking = {
                        'cabin-name' : button.parentNode.previousElementSibling.querySelector('h5').textContent,
                        'bedroom' : button.parentNode.previousElementSibling.querySelector('#bedroom').textContent,
                        'week' : button.parentNode.previousElementSibling.querySelector('small').textContent,
                        'reference' : button.parentNode.previousElementSibling.querySelector('#reference').textContent
                    }

                    const areaDeleteModal = {
                        'cabin-name' : modalType.querySelector('#cabin-name'),
                        'bedroom' : modalType.querySelector('#bedroom'),
                        'week' : modalType.querySelector('#week'),
                        'reference' : modalType.querySelector('#bookingReference')
                    }

                    areaDeleteModal["cabin-name"].textContent = deleteBooking["cabin-name"];
                    areaDeleteModal["bedroom"].textContent = deleteBooking["bedroom"];
                    areaDeleteModal["week"].textContent = deleteBooking["week"];
                    areaDeleteModal["reference"].textContent = deleteBooking["reference"];

                    break

                case updateModal:
                    const updateBooking = {
                        'bedroom' : (button.parentNode.previousElementSibling.querySelector('#bedroom').textContent).substring(0, 1),
                        'reference' : button.parentNode.previousElementSibling.querySelector('#reference').textContent,
                        'weekPicker' : button.parentNode.previousElementSibling.querySelector('#week').getAttribute('value')
                    }

                    const areaUpdateModal = {
                        'bedroom' : modalType.querySelector('#bedroom'),
                        'reference' : modalType.querySelector('#bookingReference'),
                        'weekPicker' : modalType.querySelector('#weekPicker')
                    }
                    areaUpdateModal["bedroom"].value = updateBooking['bedroom'];
                    areaUpdateModal["weekPicker"].value = updateBooking["weekPicker"];
                    areaUpdateModal["reference"].textContent = updateBooking["reference"];

                    break
            }
        })
    }
}
loadModal(deleteModal)
loadModal(updateModal)

const cabinsList = {
    1 : ['Chalet 11', 'Chalet 12', 'Chalet 13', 'Chalet 14'],
    2 : ['Chalet 21', 'Chalet 22', 'Chalet 23', 'Chalet 24'],
    3 : ['Chalet 31', 'Chalet 32', 'Chalet 33', 'Chalet 34'],
    4 : ['Chalet 41', 'Chalet 42'],
    5 : ['Chalet 51', 'Chalet 52']
};

// Create a booking in the user interface

const createButton = document.querySelector('#createButton');
createButton.addEventListener('click', () => {
    const week = document.querySelector('#createWeek').value
    const bedroom = document.querySelector('#createBedroom').value
    const cabinName = cabinsList[bedroom][0]
    createBooking(cabinName, bedroom, week);
    document.querySelector('#createWeek').value = ''
    document.querySelector('#createBedroom').value = '0'
});

// Delete a booking in the user interface 

const deleteButton = deleteModal.querySelector('#deleteButton');
deleteButton.addEventListener('click', () => {
    const idDelete = deleteModal.querySelector('#bookingReference').textContent; 
    const bookingDiv = document.querySelector(`#div${idDelete}`); console.log(bookingDiv)
    bookingDiv.remove();
});

// Update a booking in the user interface

const updateButton = updateModal.querySelector('#updateButton');

updateButton.addEventListener('click', () => {
    const idUpdate = updateModal.querySelector('#bookingReference').textContent;
    const bookingDiv = document.querySelector(`#div${idUpdate}`);

    const bedroomNumber = updateModal.querySelector('#bedroom').value;

    bookingDiv.querySelector('small').textContent = formatWeekPicker(updateModal.querySelector('#weekPicker').value);
    bookingDiv.querySelector('#bedroom').textContent = `${bedroomNumber} chambre(s)`;
    bookingDiv.querySelector('h5').textContent = cabinsList[bedroomNumber][0];

    bookingDiv.querySelector('img').setAttribute('src', `/images/${bedroomNumber}rooms.png`)
});


