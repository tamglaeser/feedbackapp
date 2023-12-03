<template>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="text-center mb-3">
            <h6>Please select a file (JSON or CSV) to import</h6>
            <input
                type="file"
                @change="handleFileUpload"
                accept=".json, .csv"
                id="file"
            />
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    methods: {
        async handleFileUpload(event) {
            const file = event.target.files[0];

            const formData = new FormData();
            formData.append('file', file);

            // Check if the uploaded file matches the accepted formats
            if (file.type === 'application/json' || file.type === 'text/csv') {
                // Process the file
                // Here, you can perform actions like reading the file or uploading it to a server
                try {
                    const response = await axios.post('/api/feedback/upload', formData);
                    console.log('File accepted:', file.name);
                } catch (error) {
                    console.error(error);
                }
            } else {
                alert('Please upload a JSON or CSV file.');
                // Reset the input to clear the selected file (optional)
                event.target.value = '';
            }
        }
    }
};
</script>
