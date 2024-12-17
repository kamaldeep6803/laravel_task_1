<form id="user-form">
    <input type="text" id="name" name="name" placeholder="Name" required>
    <input type="email" id="email" name="email" placeholder="Email" required>
    <input type="text" id="phone" name="phone" placeholder="Phone (Indian)" required>
    <textarea id="description" name="description" placeholder="Description" required></textarea>
    <select id="role_id" name="role_id" required>
        <option value="">Select Role</option>
        <option value="1">Admin</option>
        <option value="2">User</option>
        <!-- Dynamically load roles -->
    </select>
    <input type="file" id="profile_image" name="profile_image">
    <button type="submit">Submit</button>
</form>

<table id="user-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Role</th>
            <th>Profile Image</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dynamically loaded data here -->
    </tbody>
</table>

<script>
document.getElementById('user-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);

    fetch('/api/users', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('User saved successfully');
            loadUserTable();
        } else {
            alert('Error: ' + JSON.stringify(data.errors));
        }
    })
    .catch(error => console.error('Error:', error));
});

function loadUserTable() {
    fetch('/api/users')
        .then(response => response.json())
        .then(users => {
            let tableBody = document.querySelector('#user-table tbody');
            tableBody.innerHTML = '';  // Clear existing table rows

            users.forEach(user => {
                let row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.description}</td>
                    <td>${user.role.name}</td>
                    <td><img src="/images/${user.profile_image}" width="50" height="50"></td>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
}

// Load user table on page load
window.onload = loadUserTable;
</script>
