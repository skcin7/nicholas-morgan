import {BasePage} from './BasePage';

class ExamplePage extends BasePage {
    constructor() {
        super('ExamplePage');
    }

    load() {
        // let dropdowns = document.querySelectorAll('.dropdown-submenu');
        // dropdowns.forEach((dd)=>{
        //     dd.addEventListener('mouseover', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'none':'block'
        //     })
        //     dd.addEventListener('mouseout', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'block':'none'
        //     })
        // });

        // let dropdowns = document.querySelectorAll('.dropdown-toggle');
        // dropdowns.forEach((dd)=>{
        //     dd.addEventListener('click', function (e) {
        //         var el = this.nextElementSibling
        //         el.style.display = el.style.display==='block'?'none':'block'
        //     })
        // });
    }

}

export {ExamplePage};
