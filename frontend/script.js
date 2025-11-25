// Users with avatars
const users = [
    {name: "Therapist", avatar: "https://cdn-icons-png.flaticon.com/512/3135/3135715.png", lastSeen: "10:30 AM"},
    {name: "Patient A", avatar: "https://cdn-icons-png.flaticon.com/512/149/149071.png", lastSeen: "10:32 AM"},
    {name: "Patient B", avatar: "https://cdn-icons-png.flaticon.com/512/149/149071.png", lastSeen: "10:35 AM"},
    {name: "Patient C", avatar: "https://cdn-icons-png.flaticon.com/512/149/149071.png", lastSeen: "10:40 AM"}
];

const userList = document.getElementById("userList");
const chatBox = document.getElementById("chatBox");
const sendBtn = document.getElementById("sendBtn");
const messageInput = document.getElementById("messageInput");
const attachBtn = document.getElementById("attachBtn");
const imgInput = document.getElementById("imgInput");
const voiceBtn = document.getElementById("voiceBtn");

let currentUser = users[0]; // default selected user

// Render users with last seen
users.forEach(user => {
    const li = document.createElement("li");
    li.className = "user";
    li.innerHTML = `<img src="${user.avatar}"><div><span>${user.name}</span><br><small>Last seen: ${user.lastSeen}</small></div>`;
    li.onclick = () => selectUser(user);
    userList.appendChild(li);
});

// Select user
function selectUser(user) {
    currentUser = user;
    chatBox.innerHTML = ""; // empty chat
}

// Send text
sendBtn.onclick = () => {
    if (!currentUser) return;
    const text = messageInput.value.trim();
    if (!text) return;

    addMessage(text, "me");
    messageInput.value = "";

    // Simulate patient reply after 1.5s
    setTimeout(() => {
        addMessage(`${currentUser.name} says: Received your message`, "them");
    }, 1500);
};

// Function to add message
function addMessage(text, type) {
    const msgDiv = document.createElement("div");
    msgDiv.className = `message ${type}`;

    const time = new Date();
    const h = time.getHours();
    const m = time.getMinutes().toString().padStart(2, '0');
    const timestamp = `${h}:${m}`;

    msgDiv.innerHTML = `<span>${text}</span><span class="timestamp">${timestamp}</span>`;
    chatBox.appendChild(msgDiv);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Attach image
attachBtn.onclick = () => imgInput.click();
imgInput.onchange = function() {
    if (!currentUser) return;
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const imgDiv = document.createElement("div");
        imgDiv.className = "message me";
        const time = new Date();
        const h = time.getHours();
        const m = time.getMinutes().toString().padStart(2, '0');
        const timestamp = `${h}:${m}`;
        imgDiv.innerHTML = `<img src="${e.target.result}"><span class="timestamp">${timestamp}</span>`;
        chatBox.appendChild(imgDiv);
        chatBox.scrollTop = chatBox.scrollHeight;

        // Simulate patient reply
        setTimeout(() => {
            addMessage(`${currentUser.name} received your image`, "them");
        }, 1500);
    }
    reader.readAsDataURL(file);
};

// Voice note (simulated)
voiceBtn.onclick = () => {
    if (!currentUser) return;
    addMessage("🎤 Voice note sent", "me");

    setTimeout(() => {
        addMessage(`${currentUser.name} received your voice note`, "them");
    }, 1500);
};
