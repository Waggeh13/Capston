function validation() {
  document.getElementById("idError").textContent = "";
  document.getElementById("passwordError").textContent = "";

  let isValid = true;

  var user_id = document.getElementById("user_id").value.trim();
  var loginPassword = document.getElementById("password").value;

  if (!/^[a-zA-Z0-9]+$/.test(user_id) || user_id.length < 8) {
    document.getElementById("idError").textContent = "Invalid user ID (min 8 alphanumeric characters)";
    isValid = false;
  }

  if (
    loginPassword.length < 8 ||
    !/[a-zA-Z]/.test(loginPassword) ||
    !/\d/.test(loginPassword) ||
    !/[!@#$%^&*(),.?":{}|<>]/.test(loginPassword)
  ) {
    document.getElementById("passwordError").textContent = "Password must be at least 8 characters with letters, numbers, and a special character";
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
        if (this.status === 200) {
          if (response.error) {
            document.getElementById("idError").textContent = response.message;
          } else {
            switch (response.user_role) {
              case "SuperAdmin":
                window.location.href = '../view/super_admin_dashboard.php';
                break;
              case "Admin":
                window.location.href = '../view/admin_dashboard.php';
                break;
              case "Doctor":
                window.location.href = '../view/doctor_dashboard.php';
                break;
              case "Lab Technician":
                window.location.href = '../view/lab_technician.php';
                break;
              case "Pharmacist":
                window.location.href = '../view/pharmacist.php';
                break;
              case "Cashier":
                window.location.href = '../view/cashier.php';
                break;
              case "Patient":
                window.location.href = '../view/patient_dashboard.php';
                break;
              default:
                document.getElementById("idError").textContent = "Unrecognized user role.";
            }
          }
        }
      } catch (e) {
        document.getElementById("idError").textContent = "An error occurred during login.";
      }
    });

    xhr.addEventListener('error', function () {
      document.getElementById("idError").textContent = "Network error occurred.";
    });

    xhr.send('submit=true&user_id=' + encodeURIComponent(user_id) + '&password=' + encodeURIComponent(password));
  }
});

// Optional: Only run this code if show-password icon exists
var showPasswordIcon = document.getElementById("show-password");
var passwordField = document.getElementById("password");

if (showPasswordIcon && passwordField) {
  showPasswordIcon.addEventListener('click', function () {
    passwordField.type = passwordField.type === "password" ? "text" : "password";
    showPasswordIcon.classList.add("blinking");

    setTimeout(function () {
      showPasswordIcon.classList.remove("blinking");
    }, 1000);
  });
}
