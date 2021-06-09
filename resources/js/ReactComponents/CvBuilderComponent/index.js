import React from 'react';
import ReactDOM from 'react-dom';
import App from "./App";

class NISE_CvBuilderComponent extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({mode: 'open'});
        ReactDOM.render(
            <>
                <App/>
            </>,
            this.shadowRoot
        );
    }
}

customElements.define("nise-cv-builder", NISE_CvBuilderComponent);
