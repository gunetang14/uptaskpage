const mobileMenuBTn = document.querySelector('#mobile-menu');
const cerrarMenuBtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');

if(mobileMenuBTn) {
    mobileMenuBTn.addEventListener('click', function() {
        sidebar.classList.toggle('mostrar');
        mobileMenuBTn.classList.add('ocultar');
    });
}

if(cerrarMenuBtn){
    cerrarMenuBtn.addEventListener('click', function(){
        
        sidebar.classList.add('ocultar');
        mobileMenuBTn.classList.remove('ocultar');
        setTimeout( () => {
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');
        }, 500);
        
    })
}

// elimina la clase de mostrar en un tamaño de tablet o mas

const anchoPantalla = document.body.clientWidth;

window.addEventListener('resize', function(){
    const anchoPantalla = document.body.clientWidth;
    if(anchoPantalla >= 768){
        sidebar.classList.remove('mostrar');
        if(mobileMenuBTn.classList.contains('ocultar')){
            mobileMenuBTn.classList.remove('ocultar');
        }
    }
});