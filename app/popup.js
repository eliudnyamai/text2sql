document.addEventListener("DOMContentLoaded", function () {
    const accessToken = localStorage.getItem("access_token");
    if (accessToken) {
        // Redirect to "p.html" if the access token is available
        window.location.href = "popup.html";
    } else {
        // Show the login form if the access token is not available
        document.getElementById("loginForm").style.display = "block";
    }
        // document.getElementById("registrationForm").addEventListener("submit", function (event) {
        //     event.preventDefault();

        //     const formData = new FormData(this);

        //     fetch("http://127.0.0.1:8000/api/register", {
        //         method: "POST",
        //         headers: {
        //             'Accept': 'application/json',
        //             'Content-Type': 'application/json',
        //         },
        //         body: JSON.stringify(Object.fromEntries(formData)),
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         const messageDiv = document.getElementById("message");
        //         if (data.success) {
        //             messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        //             window.location.href = "popup.html";
        //         } else {
        //             messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        //         }
        //     })
        //     .catch(error => {
        //         const messageDiv = document.getElementById("message");
        //         messageDiv.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        //     });
        // });

        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch("http://127.0.0.1:8000/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById("message");
                if (data.success) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    localStorage.setItem("access_token", data.access_token);
                    window.location.href = "popup.html";
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                const messageDiv = document.getElementById("message");
                messageDiv.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
        });
   
});

function convertTextToSQL(text) {
    // Implement your text-to-SQL conversion logic here
    // You can use regular expressions or other methods to parse and convert text
    // Example: Replace "SELECT" with "SELECT * FROM table_name WHERE condition;"
    return text;
}
