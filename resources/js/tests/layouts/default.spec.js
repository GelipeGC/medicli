import { mount } from '@vue/test-utils';
import Defautl from '@/layouts/default'
describe('Component default', () => {
    test('it has name', () => {
        const wrapper = mount(Defautl);

        expect(wrapper.name()).toBe('MainLayout')
    })
})