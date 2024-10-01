function validatePcode2() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var messageBox = document.getElementById("pcode2Hint");

    if (!password || !confirmPassword) {
        messageBox.innerHTML = "";
        messageBox.style.color = "initial";
        return;
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/WebServerProject_Winter2024/src/signup-onkeyup/pcode2-ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var responseText = this.responseText.trim();
                if (responseText === "Valid!") {
                    messageBox.innerHTML = "Valid!";
                    messageBox.style.color = "green";
                } else {
                    messageBox.innerHTML = responseText;
                    messageBox.style.color = "red";
                }
            } else {
                console.error("Server responded with status: ", this.status);
                messageBox.innerHTML = "Validation error, please try again.";
                messageBox.style.color = "red";
            }
        }
    };
    xhr.send("password=" + encodeURIComponent(password) + "&confirmPassword=" + encodeURIComponent(confirmPassword));
}
