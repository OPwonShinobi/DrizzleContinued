function validateForm() {
    var x = document.forms["forgotform"]["email"].value;
    if (x == "") {
        document.getElementById('forgot-empty').style.display='block';
        return false;
    }
}



