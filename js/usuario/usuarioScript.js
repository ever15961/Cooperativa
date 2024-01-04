$(document).ready(function(){
    iniciar();
});

function iniciar(){
    document.querySelector("#btnIniciarSesion").addEventListener("click",iniciarSesion);
}

function iniciarSesion(e){
    e.preventDefault();

    alert();

    var form = new FormData(this.parentElement.parentElement);
    form.append("operacion","iniciarSesion");

    fetch("../dao/daoUsuario.php",{
        method:"POST",
        body:form
    }).then((response)=>{
        if(response.ok){
            return response.text();
        }else{
            throw "Ha ocurrido un error";
        }
    }).then((response)=>{
       redirect(response);
    }).catch(()=>{
        console.log("error en la petición");
    })
}

function redirect(response){
    //alert(response);
    location.href = "../";
}