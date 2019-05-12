// Simple form validation that checks that necessary fields are not empty

function validateForm() {
    var name = document.forms["inputform"]["name"].value;
    var address = document.forms["inputform"]["address"].value;
    var latitude = document.forms["inputform"]["latitude"].value;
    var longitude = document.forms["inputform"]["longitude"].value;
    var keywords = document.forms["inputform"]["type"].value;
    if(name == "") {
        document.getElementById("name").style.backgroundColor="rgba(255,0,0,0.2)";
        return false;
    } else if (address == "") {
        document.getElementById("address").style.backgroundColor="rgba(255,0,0,0.2)";
        return false;
    } else if (latitude == "") {
        document.getElementById("latitude").style.backgroundColor="rgba(255,0,0,0.2)";
        return false;
    } else if (longitude == "") {
        document.getElementById("longitude").style.backgroundColor="rgba(255,0,0,0.2)";
        return false;
    } else if (keywords == "") {
        document.getElementById("keywords").style.backgroundColor="rgba(255,0,0,0.2)";
        return false;
    } else {
        return true;
    }
}