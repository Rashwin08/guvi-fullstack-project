// ===== Helper functions =====

function alertBox(message, type = "info") {
    $("#alert-box").html(`
        <div class="alert alert-${type} alert-dismissible fade show">
            ${message}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
}

function getToken() {
    return localStorage.getItem("guvi_token");
}

function setToken(token) {
    localStorage.setItem("guvi_token", token);
}

function clearToken() {
    localStorage.removeItem("guvi_token");
}

// ===== Register =====

$("#btn_register").click(function () {
    let payload = {
        email: $("#reg_email").val(),
        password: $("#reg_pass").val()
    };

    $.ajax({
        url: "../backend/register.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(payload),

        success: (res) => alertBox(res.message, "success"),
        error: (xhr) =>
            alertBox(xhr.responseJSON?.message || "Register failed", "danger"),
    });
});

// ===== Login =====

$("#btn_login").click(function () {
    let payload = {
        email: $("#log_email").val(),
        password: $("#log_pass").val()
    };

    $.ajax({
        url: "../backend/login.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(payload),

        success: function (res) {
            if (res.token) {
                setToken(res.token);
                alertBox("Login successful", "success");
            }
        },
        error: function (xhr) {
            alertBox(xhr.responseJSON?.message ?? "Login failed", "danger");
        }
    });
});

// ===== Save Profile =====

$("#btn_save_profile").click(function () {
    let payload = {
        full_name: $("#pname").val(),
        bio: $("#pbio").val(),
        skills: $("#pskills").val().split(",").map(s => s.trim())
    };

    $.ajax({
        url: "../backend/profile_save.php",
        method: "POST",
        contentType: "application/json",
        headers: { "X-Session-Token": getToken() },
        data: JSON.stringify(payload),

        success: (res) => alertBox("Profile saved", "success"),
        error: (xhr) =>
            alertBox(xhr.responseJSON?.message || "Save failed", "danger"),
    });
});

// ===== Load Profile =====

$("#btn_load_profile").click(function () {
    $.ajax({
        url: "../backend/profile_get.php",
        method: "POST",
        contentType: "application/json",
        headers: { "X-Session-Token": getToken() },
        data: JSON.stringify({}),

        success: (res) => {
            $("#profile_output").text(
                JSON.stringify(res.profile, null, 2)
            );
        },
        error: (xhr) =>
            alertBox(xhr.responseJSON?.message || "Load failed", "danger"),
    });
});

// ===== Logout =====

$("#btn_logout").click(function () {
    $.ajax({
        url: "../backend/logout.php",
        method: "POST",
        headers: { "X-Session-Token": getToken() },

        success: () => {
            clearToken();
            alertBox("Logged out!", "info");
        }
    });
});
