<template>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h2 class="mb-4"> Complete your review </h2>
            <form method="post" @submit.prevent="submitFeedback">
                <div class="mb-3">
                    <label for="review" class="form-label">Review:</label>
                    <textarea class="form-control" id="review" v-model="feedback.review" placeholder="What is your feedback?" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating:</label>
                    <input type="number" class="form-control" id="rating" v-model="feedback.rating" min="1" max="10" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" v-model="feedback.start_date" :max="maxDate" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" class="form-control" id="address" v-model="feedback.address" required>
                </div>
                <div class="mb-3">
                    <label for="appartments" class="form-label">Appartments:</label>
                    <select class="form-control" id="appartments" v-model="feedback.appartments" required>
                        <option disabled value="">Please select one</option>
                        <option>Solstice Apartments</option>
                        <option>Kings Dock Mill Liverpool</option>
                        <option>Windlass Apartments</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="source" class="form-label">Source:</label>
                    <select class="form-control" id="source" v-model="feedback.source" required>
                        <option disabled value="">Please select one</option>
                        <option>allAgents</option>
                        <option>Google</option>
                        <option>Truspilot</option>
                    </select>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </form>
            <div v-if="!addressValid">  <!--Need to improve validateFunction-->
                Address format is invalid.
            </div>
            <div v-if="feedbackSubmitted" class="success-message">
                Thank you for your feedback!
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            feedback: {
                review: '',
                rating: null,
                start_date: '',
                address: '',
                appartments: '',
                source: ''
            },
            maxDate: '',
            feedbackSubmitted: false,
            addressValid: true
        };
    },
    mounted() {
        // Set max date to today for the start_date input
        const today = new Date().toISOString().split('T')[0];
        this.maxDate = today;
    },
    methods: {
        validateAddress() {
            // Regular expression pattern for a simple address format
            const addressPattern = /^[0-9]+(\s[A-Za-z0-9'-]+)+,\s[A-Za-z]+,\s[A-Za-z]+\s[0-9]+$/;
            // Check if the input address matches the expected pattern
            if (addressPattern.test(this.feedback.address)) {
                this.addressValid = true;
            } else {
                this.addressValid = false;
            }
        },
        async submitFeedback() {
            try {

                // Make sure 'start_date' is in the correct format
                this.feedback.start_date = new Date(this.feedback.start_date).toISOString();

                const response = await axios.post('/api/feedback', this.feedback);

                if (response.status === 201) {
                    this.feedbackSubmitted = true;
                    // Clear the form or reset the feedback object
                    this.feedback = {
                        review: '',
                        rating: null,
                        start_date: '',
                        address: '',
                        appartments: '',
                        source: ''
                    };
                }
            }
            catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
<style scoped>
button {
    display: inline-block;
    background-color: #0e8f00;
    border: solid 1px #0e8f00;
    color: white;
    padding: 5px;
    margin: 10px;
}
</style>
