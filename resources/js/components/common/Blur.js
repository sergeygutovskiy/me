export default class Blur {
    constructor(elmenent) {
        if (elmenent === null || elmenent === undefined) {
            throw new Error('No blur');
        }

        this._blur_el = elmenent;
        
        const style = getComputedStyle(this._blur_el);
        this._blur_el_animation_time = style.getPropertyValue('--animation-time');
    }

    open() {
        this._blur_el.classList.add('opened');
        this._blur_el.classList.add('active');
    }

    close() {
        this._blur_el.classList.remove('active');
        setTimeout(
            () => this._blur_el.classList.remove('opened'), 
            this._blur_el_animation_time
        );
    }
}