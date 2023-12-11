// ***FONCTIONS***

setElements=(datas,attribut,value) => { 
        datas.forEach(data => {
            data.forEach(element => {
                element.setAttribute(attribut,value);
            });
        })
    };

newTagElements=(attribut,strattribut,tab) => {
    attribut =  Array.from (document.querySelectorAll(strattribut));
        tab.push(attribut);
}

const font = document.querySelector('#read');
let body;
let form;
let input;
let textarea;
let button;
let tabFont = [];
newTagElements(body,'body',tabFont);
newTagElements(form,'form',tabFont);
newTagElements(input,'input',tabFont);
newTagElements(textarea,'textarea',tabFont);
newTagElements(button,'button',tabFont);
let activefont = true;

const access = document.querySelector('#access');
let tabColor = [];
let infos;
let personnages;
let main;
let navbar;
// newTagElements(body,'body',tabColor);
newTagElements(form,'form',tabColor);
newTagElements(input,'input',tabColor);
newTagElements(textarea,'textarea',tabColor);
newTagElements(button,'button',tabColor);
newTagElements(infos,'.infos',tabColor);
newTagElements(personnages,'.personnage',tabColor);
newTagElements(infos,'.main',tabColor);
newTagElements(navbar,'.navbar-item',tabColor);
let activeaccess = true;

font.addEventListener('click',()=> {
    
    if (activefont == true) {
       setElements(tabFont,'style','font-family: Arial, Helvetica, sans-serif;');
        activefont = !activefont;
    } else {
        setElements(tabFont,'style','');
        activefont = !activefont;
    }
})

access.addEventListener('click',()=> {
    if (activeaccess == true) {
        setElements(tabColor,'style','background-color: antiquewhite; color: #181818;');
        activeaccess = !activeaccess;
    } else {
        setElements(tabColor,'style','');
        activeaccess = !activeaccess;
    }

})

