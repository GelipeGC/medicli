import { mount } from 'vue-test-utils';
import Layout from '@/layouts/basic';


test('default data is correct', () => {
    const wrapper = mount(Layout);
    expect(wrapper.name()).toBe('BasicLayout');
});