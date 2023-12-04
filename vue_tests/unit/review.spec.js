import { mount } from '@vue/test-utils';
import Review from '../../resources/js/components/Review.vue';

describe('Review', () => {
    it('renders form fields correctly', () => {
        const wrapper = mount(Review);

        // Check if form fields exist and are rendered properly
        expect(wrapper.find('form').exists()).toBe(true);
        expect(wrapper.find('#review').exists()).toBe(true);
        expect(wrapper.find('#rating').exists()).toBe(true);
        expect(wrapper.find('#start_date').exists()).toBe(true);
        expect(wrapper.find('#address').exists()).toBe(true);
        expect(wrapper.find('#appartments').exists()).toBe(true);
        expect(wrapper.find('#source').exists()).toBe(true);
    });
    it('submits feedback on form submission', async () => {
        const wrapper = mount(Review);

        // Simulate form input
        await wrapper.find('#review').setValue('Test review');
        await wrapper.find('#rating').setValue('8');
        await wrapper.find('#start_date').setValue('2023-12-02');
        await wrapper.find('#address').setValue('10 rue de Paris');
        await wrapper.find('#appartments').setValue('Windlass Apartments');
        await wrapper.find('#source').setValue('Google');

        // Mock the submitFeedback method to prevent actual API calls
        wrapper.vm.submitFeedback = jest.fn();

        // Trigger form submission
        await wrapper.find('form').trigger('submit');

        // Check if submitFeedback method was called
        expect(wrapper.vm.submitFeedback).toHaveBeenCalled();
    });
})
