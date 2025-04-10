function validation() {
  document.getElementById("idError").textContent = "";
  document.getElementById("passwordError").textContent = "";

  let isValid = true;

  var user_id = document.getElementById("user_id").value;
  var loginPassword = document.getElementById("password").value;

  if (!/^[a-zA-Z0-9]+$/.test(user_id) || user_id.length < 8) {
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
      try {
        var response = JSON.parse(this.responseText);
        if (this.status == 200) {
          if (response.error) {
            document.getElementById("idError").textContent = response.message;
          } else {
            if (response.user_role == "Doctor") {
              window.location.href = '../view/doctor_dashboard.php';
            } else if (response.user_role == "Lab Technician") {
              window.location.href = '../view/userDash.php';
            } else if (response.user_role == "Pharmacist") {
              window.location.href = '../view/pharmacist.php';
            } else if (response.user_role == "Cashier") {
              window.location.href = '../view/doctor_dashboard.php';
            }
            // Add more role redirections as needed
          }
        }
      } catch (e) {
        document.getElementById("idError").textContent = "An error occurred during login";
      }
    });

    xhr.addEventListener('error', function() {
      document.getElementById("idError").textContent = "Network error occurred";
    });

    xhr.send('submit=true&user_id=' + encodeURIComponent(user_id) + '&password=' + encodeURIComponent(password));
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