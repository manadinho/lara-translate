@extends("lara-translate::layout")
@section("content")
<div class="panel w-2/3 m-auto my-8">
    <div class="panel-header">
        {{__("Add a language")}}
    </div>
    <form action="{{ route('lara-translate.store') }}" method="POST">
        <fieldset>
            @csrf
            <div class="panel-body p-4">

                <div class="input-group">
                    <label for="key">
                        {{__("Name")}} <stong>*</stong>
                    </label>
                    <input name="name" id="name" type="text" value="" />
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