@extends('core.main')
@php
    /** @var \Softbd\Acl\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@section('content')
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card" style="width: 300px; height: 300px; overflow: scroll">
                    <fetch-user></fetch-user>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 300px; height: 300px; overflow: scroll">
                    <fetch-user></fetch-user>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 300px; height: 300px; overflow: scroll">
                    <fetch-user></fetch-user>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        class FetchUser extends HTMLElement {
            constructor() {
                super();
                const _style = document.createElement('style');
                const _template = document.createElement('template');

                _style.innerHTML = `
        h1 {
          color: tomato;
        }
        `;
                _template.innerHTML = `<ul id="users" style="list-style: none; padding: 0"></ul>`;

                this.attachShadow({mode: 'open'});
                this.shadowRoot.appendChild(_style);
                this.shadowRoot.appendChild(_template.content.cloneNode(true));

                fetch('https://jsonplaceholder.typicode.com/todos')
                    .then((response) => response.json())
                    .then((data) => {
                        data.forEach((item) => {
                            let li = document.createElement('li');
                            li.style.padding = '3px';
                            li.style.textAlign = 'left';
                            li.style.border = '1px solid gray';
                            li.appendChild(document.createTextNode(item.title));
                            this.shadowRoot.querySelector("#users").appendChild(li);
                        });
                    });
            }

            static get observedAttributes() {
                return ["theme"];
            }

            attributeChangedCallback(name, oldVal, newVal) {
                console.table({name, oldVal, newVal});
            }

            connectedCallback() {
                console.log("Element added to the dom");
            }

            disconnectedCallback() {
                console.log("Element removed from dom")
            }
        }

        window.customElements.define('fetch-user', FetchUser);
    </script>
@endpush
