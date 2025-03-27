function validation() {
  document.getElementById("idError").textContent = "";
  document.getElementById("passwordError").textContent = "";

  let isValid = true;

  var user_id = document.getElementById("user_id").value;
  var loginPassword = document.getElementById("password").value;

  if (!/^[a-zA-Z0-9]+$/.test(user_id) || user_id < 8 ) {
    document.getElementById("idError").textContent = "Invalid user Id";
    isValid = false;
}


  if (loginPassword.length < 8 ||
      !/[a-zA-Z]/.test(loginPassword) ||
      !/\d/.test(loginPassword) ||
      !/[!@#$%^&*(),.?":{}|<>]/.test(loginPassword)) {
    document.getElementById("passwordError").textContent = "Invalid Password";
    isValid = false;
  }

  return isValid;
}

document.getElementById('loginForm').addEventListener('submit', function (event) {
  event.preventDefault();

  if (validation()) {
    var user_id = document.getElementById("user_id").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../actions/login_user_action.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.addEventListener('load', function () {
      var response = JSON.parse(this.responseText);
      if (this.status == 200) {
        if (response.error) {
          if (response.errorType === 'user_id') {
            document.getElementById("IdError").textContent = response.message;
          } else if (response.errorType === 'password') {
            document.getElementById("passwordError").textContent = response.message;
          } else {
            document.getElementById("generalError").textContent = "An unexpected error occured:" + response.message;
          }
        } else {
          console.log("User Role:", response.user_role);

          if (response.user_role == 1) {
            window.location.href = '../view/viewproduct.php';
          } else if (response.user_role == 2) {
            window.location.href = '../view/userDash.php';
          }
          else if (response.user_role ==3) {
            window.location.href = '../view/admindashboard.php';
          }
        }
      }
    });

    xhr.send('submit=true&email=' + encodeURIComponent(user_id) + '&password=' + encodeURIComponent(password));
  }
});

var showPasswordIcon = document.getElementById("show-password");
var passwordField = document.getElementById("password");

showPasswordIcon.addEventListener('click', function () { 
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
  showPasswordIcon.classList.add("blinking");

  setTimeout(function() {
    showPasswordIcon.classList.remove("blinking");
  }, 1000);
});
