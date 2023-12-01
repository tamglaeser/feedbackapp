<template>
    <form method="post" @submit.prevent="submitFeedback">
        <div class="form-group">
            <p>Review:</p>
            <textarea v-model="feedback.review" placeholder="What is your feedback?" required></textarea>
        </div>
        <div class="form-group">
            <p>Rating:</p>
            <input v-model="feedback.rating" type="number" min="1" max="10" required>
        </div>
        <div class="form-group">
            <p>Start Date:</p>
            <input v-model="feedback.start_date" type="date" :max="maxDate" required>  <!--YYYY-MM-DD HH:mm:ss, YYYY/MM/DD-->
        </div>
        <div class="form-group">
            <p>Address:</p>
            <input v-model="feedback.address" required>
        </div>
        <div class="form-group">
            <p>Appartments:</p>
            <select v-model="feedback.appartments" required>
                <option disabled value="">Please select one</option>
                <option>Solstice Apartments</option>
                <option>Kings Dock Mill Liverpool</option>
                <option>Windlass Apartments</option>
            </select>
        </div>
        <div class="form-group">
            <p>Source:</p>
            <select v-model="feedback.source" required>
                <option disabled value="">Please select one</option>
                <option>allAgents</option>
                <option>Google</option>
                <option>Truspilot</option>
            </select>
        </div>
        <button type="submit">Submit Feedback</button>
    </form>
    <div v-if="!addressValid">  <!--Need to improve validateFunction-->
        Address format is invalid.
    </div>
    <div v-if="feedbackSubmitted" class="success-message">
        Thank you for your feedback!
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
            console.log("test");
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
                //const secresp = await axios.get('/api/feedback');

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
