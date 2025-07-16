// Simple client-side validation (easily bypassed - for demonstration)
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.querySelector('form[enctype="multipart/form-data"]');
    
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput.files.length === 0) {
                alert('Please select a file to upload');
                e.preventDefault();
                return false;
            }
            
            // Client-side validation can be easily bypassed
            const file = fileInput.files[0];
            const fileName = file.name;
            const fileSize = file.size;
            
            console.log('Client-side validation (easily bypassed):');
            console.log('Filename:', fileName);
            console.log('Filesize:', fileSize, 'bytes');
            
            return true;
        });
    }
    
    // Simulate admin toggle for demo purposes
    const adminToggle = document.createElement('div');
    adminToggle.className = 'fixed bottom-4 right-4 bg-white p-3 rounded shadow-lg';
    adminToggle.innerHTML = `
        <label class="flex items-center space-x-2">
            <span class="text-sm font-medium">Admin Mode</span>
            <input type="checkbox" id="adminToggle" class="rounded text-blue-600">
        </label>
    `;
    document.body.appendChild(adminToggle);
    
    document.getElementById('adminToggle').addEventListener('change', function() {
        const isAdmin = this.checked;
        const url = new URL(window.location.href);
        
        if (isAdmin) {
            url.searchParams.set('admin', 'true');
        } else {
            url.searchParams.delete('admin');
        }
        
        window.location.href = url.toString();
    });
    
    // Set initial state if admin param exists
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('admin')) {
        document.getElementById('adminToggle').checked = true;
    }
});