// Usamos o script para mostrar mensagens de erro, como:

// Nome em branco, email ou senha, como também analisar se a repetição da senha no último input combina.

// LIBRARY: JustValidate

const validation = new JustValidate("#signup");

validation 

    .addField("#name", [
        {
            rule: "required"
        }
    ])
    
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        { // Caso o email já estiver em uso
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value)).then(function(response) {
                    return response.json();
                })
                .then(function(json) {
                    return json.available;
                });
            },
            errorMessage: "email already taken"
        } 
    ])

    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])

    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])

    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });