@extends("lara-translate::layout")
@section("content")
<div class="panel w-2/3 m-auto my-8">
    <div class="panel-header">
        {{__("Add a translation")}}
    </div>
    <form action="{{ route('lara-translate.translations.store') }}" method="POST">
        <fieldset>
            @csrf
            <input type="hidden" name="language" value="{{ request('lang') }}">
            <div class="panel-body p-4">

                <div class="input-group">
                    <label for="key">
                        {{__("Key")}} <stong>*</stong>
                    </label>
                    <input name="key" id="key" type="text" value="" />
                </div>

                <div class="input-group">
                    <label for="value">
                        {{__("Value")}}
                    </label>
                    <input name="value" id="value" type="text" value="" />
                </div>
            </div>
        </fieldset>
        <div class="panel-footer flex flex-row-reverse">
            <button class="button button-black">
                {{__("Save")}}
            </button>
        </div>
    </form>
</div>
@endsection