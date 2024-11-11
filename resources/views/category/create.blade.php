<x-layout>
    <x-page-heading>Add New Category</x-page-heading>

    <x-forms.form method="POST" action="/category" enctype="multipart/form-data">
        <x-forms.input label="Name" name="name" />
   

        <x-forms.button>Create</x-forms.button>
    </x-forms.form>
</x-layout>