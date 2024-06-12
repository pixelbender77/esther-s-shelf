//Used to define form validation information ~ including password and repeat_password integrity (they must match)
const validation = new JustValidate("#signup");

//Below we define the fields to be validated in the app.
validation
    .addField("#name", [{
        rule: "required"
    }])
    .addField("#password", [{
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#password_confirmation", [{
        validator: (value, fields) => {
            return value === fields["#password"].elem.value;
        },
        errorMessage: "Passwords should match"
    }])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });



// .addField("#email", [{
//         rule: "required"
//     },
//     {
//         rule: "email"
//     },
//     {
//         validator: (value) => () => {
//             return fetch("validate-email.php?email=" + encodeURIComponent(value))
//                 .then(function(response) {
//                     return response.json();
//                 })
//                 .then(function(json) {
//                     return json.available;
//                 });
//         },
//         errorMessage: "email already taken"
//     }
// ])