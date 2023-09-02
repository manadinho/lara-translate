@extends("lara-translate::layout")
@section("content")
    <div class="panel my-6">
        <div class="panel-header">
           {{__("Translation")}}
           <div class="flex flex-grow justify-end items-center">
              <div class="search"><input type="text" placeholder="Search All Translations" id="searchInput" name="filter" value="" class="search-input"></div>
              <div class="select-group">
                 <select name="language" id="language-dropdown">
                     @forelse($langs as $lang => $name)
                        <option value="{{ $lang }}" data-href="{{ route('lara-translate.translations.index', $lang) }}" {{ request('lang') == $lang ? 'selected':''  }}>{{$name}} ({{ $lang }})</option>
                     @empty
                     @endforelse
                 </select>
                 <div class="caret">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                       <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                    </svg>
                 </div>
              </div>
              <div class="sm:hidden lg:flex items-center"><a href="{{ route('lara-translate.translations.create', request('lang')) }}" class="button">
                 + {{__("Add")}}
                 </a>
              </div>
           </div>
        </div>
        <div class="panel-body">
           <table>
              <thead>
                 <tr>
                    <th class="w-2/5 uppercase font-thin">{{__("key")}}</th>
                    <th class="w-2/5 uppercase font-thin">{{ request('lang') }}</th>
                    <th class="uppercase font-thin">{{__("Actions")}}</th>
                 </tr>
              </thead>
              <tbody>
                @forelse($translation_content as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td><div class="input-group"><input type="text" onchange="updateTranslation('{{ $key }}', '{{ $loop->iteration }}')" id="value-{{ $loop->iteration }}" value="{{ $value }}"></div></td>
                        <td>
                            <div class="my-3">
                                <div class="spinner hidden">
                                </div>
                                @if(config('laraTranslate.show_translate_button'))
                                    <a href="javascript:void(0)" class="button translation-btn" onclick="performTranslation(this, '{{ $key }}', '{{ $loop->iteration }}')">🌍 {{__("translate")}}</a>
                                @endif
                                @if(config('laraTranslate.show_delete_button'))
                                    <button class="button-red translation-btn" onclick="deleteTranslation(this, '{{ $key }}', '{{ $loop->iteration }}')">🗑️ {{__("Delete")}}</button>
                                @endif
                                <div class="inline-block" id="checkmark-{{$key}}"></div>
                            </div>
                        </td>
                    </tr>
                 @empty
                 @endforelse
              </tbody>
           </table>
        </div>
     </div>
    <script>
        function performTranslation(element, key, iteration) {

            // hide action buttons
            element.classList.add('hidden');
            element.nextElementSibling.classList.add('hidden');

            // show spinner
            element.parentElement.querySelector('.spinner').classList.remove('hidden');

            // make action buttons unclickable
            translationButtons = document.getElementsByClassName('translation-btn');
            for (let i = 0; i < translationButtons.length; i++) {
               translationButtons[i].classList.add('pointer-events-none');
            }

            inputId = `value-${iteration}`;

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open("POST", "{{ route('lara-translate.translations.translate') }}", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            // Prepare the data to be sent in the request body
            var data = {
                translation: "{{ request('lang') }}",
                key: key
            };

            // Convert the data to a JSON string
            var jsonData = JSON.stringify(data);

            // Set up the event handler for when the request is complete
            xhr.onload = function() {
                // hide the spinner
                element.parentElement.querySelector('.spinner').classList.add('hidden');

                // show action buttons
                element.classList.remove('hidden');
                element.nextElementSibling.classList.remove('hidden');

                // make action buttons clickable
                translationButtons = document.getElementsByClassName('translation-btn');
                for (let i = 0; i < translationButtons.length; i++) {
                    translationButtons[i].classList.remove('pointer-events-none');
                }

                if (xhr.status >= 200 && xhr.status < 300) {
                    // Request was successful, handle the response
                    var response = JSON.parse(xhr.responseText);
                    if(response.success)
                    {
                        document.getElementById(inputId).value = response.translation;
                        let svg = `<svg class="checkmark addClass" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle addClass" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check addClass" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`;
                        menuExtraItemAnimation('checkmark', document.getElementById(`checkmark-${key}`), svg);
                    }
                } else {
                    
                }
            };

            // Send the request with the JSON data in the body
            xhr.send(jsonData);
        }

        function deleteTranslation(element, key, iteration) {
            // hide action buttons
            element.classList.add('hidden');
            element.previousElementSibling.classList.add('hidden');

            // show spinner
            element.parentElement.querySelector('.spinner').classList.remove('hidden');

            // make action buttons unclickable
            translationButtons = document.getElementsByClassName('translation-btn');
            for (let i = 0; i < translationButtons.length; i++) {
               translationButtons[i].classList.add('pointer-events-none');
            }

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open("POST", "{{ route('lara-translate.translations.delete') }}", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            // Prepare the data to be sent in the request body
            var data = {
                translation: "{{ request('lang') }}",
                key: key
            };

            // Convert the data to a JSON string
            var jsonData = JSON.stringify(data);

            // Set up the event handler for when the request is complete
            xhr.onload = function() {
                // hide spinner
                element.parentElement.querySelector('.spinner').classList.add('hidden');

                // show action buttons
                element.classList.remove('hidden');
                element.nextElementSibling.classList.remove('hidden');

                // make action buttons clickable
                translationButtons = document.getElementsByClassName('translation-btn');
                for (let i = 0; i < translationButtons.length; i++) {
                    translationButtons[i].classList.remove('pointer-events-none');
                }

                if (xhr.status >= 200 && xhr.status < 300) {
                    // Request was successful, handle the response
                    var response = JSON.parse(xhr.responseText);
                    if(response.success)
                    {
                        const parentRow = element.closest('tr');
                        if (parentRow) {
                            parentRow.remove();
                        }
                        return;
                    }
                } else {
                    
                }
            };

            // Send the request with the JSON data in the body
            xhr.send(jsonData);
        }

        function updateTranslation(key, iteration) {
            inputId = `value-${iteration}`;
            value = document.getElementById(inputId).value;
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open("POST", "{{ route('lara-translate.translations.update') }}", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            // Prepare the data to be sent in the request body
            var data = {
                translation: "{{ request('lang') }}",
                key: key,
                value:value
            };

            // Convert the data to a JSON string
            var jsonData = JSON.stringify(data);

            // Set up the event handler for when the request is complete
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // Request was successful, handle the response
                    var response = JSON.parse(xhr.responseText);
                    let svg = `<svg class="checkmark addClass" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle addClass" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check addClass" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`;
                    menuExtraItemAnimation('checkmark', document.getElementById(`checkmark-${key}`), svg);
                } else {
                    
                }
            };

            // Send the request with the JSON data in the body
            xhr.send(jsonData);
        }
        function menuExtraItemAnimation(className, element, svg)
        {
            element.innerHTML = svg;

            for (let i = 0; i < document.getElementsByClassName(`${className}`).length; i++) {
                console.log(document.getElementsByClassName(`${className}`)[i]);
                document.getElementsByClassName(`${className}`)[i].style.display = 'inherit';
                document.getElementsByClassName(`${className}`)[i].classList.remove('animateElement');
            }

            setTimeout(function(){
                for (let i = 0; i < document.getElementsByClassName(`${className}`).length; i++) {
                    document.getElementsByClassName(`${className}`)[i].classList.add('animateElement');
                }
            }, 1000);

            setTimeout(() => {
                element.innerHTML = '';
            }, 1600);
        }

        const languageDropdown = document.getElementById('language-dropdown');

        languageDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const dataHref = selectedOption.getAttribute('data-href');
            
            if (dataHref) {
                window.location.href = dataHref;
            }
        });

        const searchInput = document.getElementById('searchInput');
        const tableBody = document.querySelector('table tbody');

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.trim().toLowerCase();

            tableBody.querySelectorAll('tr').forEach(row => {
                const cells = Array.from(row.getElementsByTagName('td'));
                const rowMatches = cells.some(cell => cell.textContent.trim().toLowerCase().includes(searchValue));

                if (rowMatches) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection