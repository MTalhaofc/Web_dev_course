function check(){
    let a = document.getElementById("check")

    if(a.value%2==0){
        a.style.backgroundColor = "green";
    }
    else {
        a.style.backgroundColor="red";
    }
}
check();