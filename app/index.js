document.getElementById("menu_toggle").addEventListener("click",(event)=>{
    if( document.getElementById("menu_content_container").style.display == "none"){
         document.getElementById("menu_content_container").style.display ="flex"
         return
    }
    document.getElementById("menu_content_container").style.display ="none"
})