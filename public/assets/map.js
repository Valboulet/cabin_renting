
// Delete modal booking --------------------------------------------------------------------------------------------------------------------

const deleteModal = document.getElementById('deleteModal')

function loadModal(modalType) {
    if (modalType) {
        modalType.addEventListener('show.bs.modal', e => {
            const button = e.relatedTarget

            switch (modalType) {

                case deleteModal: 
                    const deleteBooking = {
                        'name' : button.getAttribute('data-client'),
                        'week' : button.getAttribute('data-week'),
                        'cabin' : button.getAttribute('data-cabin'),
                        'reference' : button.getAttribute('data-reference')
                    }
                    const areaDeleteModal = {
                        'name' : modalType.querySelector('#client-name'),
                        'week' : modalType.querySelector('#week'),
                        'cabin' : modalType.querySelector('#cabin-name'),
                        'reference' : modalType.querySelector('#reference') 
                    }
                    areaDeleteModal.name.textContent = deleteBooking.name
                    areaDeleteModal.week.textContent = deleteBooking.week
                    areaDeleteModal.cabin.textContent = deleteBooking.cabin
                    areaDeleteModal.reference.value = deleteBooking.reference

                    break

                case changeAvail:
                    break
            }
        })
    }
}

loadModal(deleteModal)
