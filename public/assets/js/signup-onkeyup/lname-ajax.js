function validateLastName() {
    var lastName = document.getElementById("lastName").value;
    var messageBox = document.getElementById("lnameHint");

    if (lastName.length == 0) {
        messageBox.innerHTML = "";
        messageBox.style.color = "initial";
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/WebServerProject_Winter2024/src/signup-onkeyup/lname-ajax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var responseText = this.responseText.trim();
                if (responseText === "Valid!") {
                    messageBox.innerHTML = responseText;
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
    xhr.send("lastName=" + encodeURIComponent(lastName));
}
