document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("question").addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            sendMessage();
        }
    });
});

function sendMessage() {
    let inputField = document.getElementById("question");
    let message = inputField.value.trim();

    if (message === "") return;

    appendMessage("Tú", message, "user");

    fetch("/ask", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({ question: message })
    })
    .then(response => response.json()) 
    .then(data => {
        console.log("Respuesta de la API:", data);

        let reply = data.mensaje || "Lo siento, no pude procesar tu pregunta.";
        appendMessage("ChatBot", reply, "bot");
    })
    .catch(error => {
        console.error("Error al enviar la pregunta:", error);
        appendMessage("ChatBot", "Hubo un error, intenta nuevamente.", "bot");
    });

    inputField.value = ""; // Limpiar campo de entrada
}

function appendMessage(sender, message, type) {
    let chatBox = document.getElementById("chat-box");
    let messageElement = document.createElement("div");
    messageElement.classList.add("message", type);
    messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
    chatBox.appendChild(messageElement);

    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll
}
async function sendMessage() {
    const question = document.getElementById("question").value;

    try {
        const response = await fetch("/ask", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ question }),
        });

        const data = await response.json();
        document.getElementById("chat-box").innerHTML += `<p>${data.mensaje}</p>`;

    } catch (error) {
        console.error("Error al enviar la pregunta:", error);
        document.getElementById("chat-box").innerHTML += "<p>Error en el servidor</p>";
    }
}
