function toggle_modal(modal_name){
    let modal = document.getElementById(modal_name) 
    modal.classList.toggle('opacity-0')
    modal.classList.toggle('pointer-events-none')
}

function toggleAlert(alert_name,status){

    let alert = document.getElementById(alert_name)
    
    if(status == "show"){
        alert.classList.remove("opacity-0")
        alert.classList.remove("-translate-y-[350px]")
    }else{

        alert.classList.add("opacity-0")
        alert.classList.add("-translate-y-[350px]")  
    }
    
}

