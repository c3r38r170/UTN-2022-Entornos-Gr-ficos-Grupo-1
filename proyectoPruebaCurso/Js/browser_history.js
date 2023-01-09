//evitamos que se reenvie el formulario php
if(window.history.replaceState){
    window.history.replaceState(null,null,window.location.href)
}