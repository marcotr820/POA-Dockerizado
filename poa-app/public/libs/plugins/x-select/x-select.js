document.addEventListener('click', (e)=>{
    if(e.target.matches('.x-select-option')){
        const button = e.target.parentElement.parentElement.parentElement.previousElementSibling;
        button.firstElementChild.textContent = e.target.textContent.trim();

        e.target.parentElement.parentElement.parentElement.classList.toggle('show');
    }

    if(e.target.matches('.x-select-button')){
        let x_select_body = document.querySelectorAll('.x-select-body');
        x_select_body.forEach((element)=>{
            if( element !== e.target.nextElementSibling ){
                element.classList.remove('show');
            }
        });
        e.target.nextElementSibling.classList.toggle('show');
    }

    if(! e.target.classList.contains('x-select-button')){
        let x_select_body = document.querySelectorAll('.x-select-body');
        x_select_body.forEach((element)=>{ element.classList.remove('show') });
    }
})