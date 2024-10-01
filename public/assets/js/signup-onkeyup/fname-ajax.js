function validateFirstName() {
    var firstName = document.getElementById("firstName").value;
    var messageBox = document.getElementById("fnameHint");

    if (firstName.length == 0) {
        messageBox.innerHTML = "";
        messageBox.style.color = "initial";
        return;
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/WebServerProject_Winter2024/src/signup-onkeyup/fname-ajax.php", true); 
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) { // Check if request is complete
                if (this.status == 200) { // Check if status is OK
                    // Handling plain text response
                    var responseText = this.responseText.trim(); // Trim whitespace
                    
                    // Assuming the server sends back "Valid!" for valid inputs
                    if (responseText === "Valid!") {
                        messageBox.innerHTML = responseText;
                        messageBox.style.color = "green";
                    } else {
                        // Any other response is considered an error message
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
        xhr.send("firstName=" + encodeURIComponent(firstName));
    }
}
