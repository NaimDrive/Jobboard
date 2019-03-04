@extends('layouts.master')
@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger"  style="margin-top: 2rem">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <h2 class="card-header">Inscription au forum du {{$forum->date}}</h2>
            <div class="card-body">
                <form action="{{ route('storeEditInscriptionForum',['id'=>$forum->id]) }}" method="POST">
                    {!! csrf_field() !!}
                    <legend>Contacts de l'entreprise participants</legend>
                    <input type="hidden" id="nbContacts" name="nbContacts" value="0">
                    <div id="contacts">
                        @php($index=0)
                        @foreach($entreprise->contacts as $contactP)
                            <div class="form-group row" id="block_contact_{{ $index }}">
                                <div class="col-md-10">
                                    <select name="contact_{{$index}}" id="contact_{{$index}}" class="form-control">
                                        @foreach($entreprise->entrepriseP->contacts as $contact)
                                            <option value="{{ $contact->id }}" {{ $contact->id == $contactP->id ? "selected" : "" }}>{{ $contact->prenom }} {{ $contact->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button id="delete_{{$index}}" class="btn btn-danger" data-action="delete" data-target="block_contact_{{$index}}" type="button">X</button>
                                </div>
                            </div>
                            @php($index++)
                        @endforeach
                    </div>
                    <button id="ajoutContact" class="btn btn-success" type="button">Ajouter un participant</button>
                    <button class="btn btn-success" type="submit">M'inscrire au forum</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javaScript')
    <script>
        for (let i=0; i < parseInt({{$index}}) ; i++){
            let button = document.getElementById("delete_"+i);
            button.addEventListener("click",deleteContact);
        }


        let divContact = document.getElementById('contacts');
        let nbContacts = document.getElementById('nbContacts');

        let btnAddContact = document.getElementById("ajoutContact");

        btnAddContact.addEventListener('click',addContact);

        function addContact(){
            let index = parseInt(divContact.childNodes.length)-1;

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class","form-group row");
            divFormGroup.setAttribute("id","block_contact_" + index);

            let divCol10 = document.createElement("div");
            divCol10.setAttribute("class","col-md-10");

            let divCol2 = document.createElement("div");
            divCol2.setAttribute("class","col-md-2");

            let selectContact = document.createElement("select");
            selectContact.setAttribute("name","contact_"+index);
            selectContact.setAttribute("id","contact_"+index);
            selectContact.setAttribute("class","form-control");

            let optionContact;
            let option;

            @foreach($entreprise->entrepriseP->contacts as $contact)
                optionContact = document.createElement("option");
            optionContact.setAttribute("value","{{$contact->id}}");

            option = document.createTextNode("{{$contact->prenom}} {{$contact->nom}}");

            optionContact.appendChild(option);

            selectContact.appendChild(optionContact);
            @endforeach

            divCol10.appendChild(selectContact);

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "delete_"+index);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_contact_"+index);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol2.appendChild(inputDelete);

            divFormGroup.appendChild(divCol10);
            divFormGroup.appendChild(divCol2);

            divContact.appendChild(divFormGroup);



            inputDelete = document.getElementById("delete_"+index);
            inputDelete.addEventListener('click',deleteContact);

            nbContacts.value = index + 1 ;
        }

        function deleteContact(){
            let index = parseInt(nbContacts.value);
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);

            let id = parseInt(target.substr(14));

            divSupprimer.remove();

            index -= 1 ;

            for(let i = id ; i < index ;i++){

                let divFormGroup = document.getElementById("block_contact_" + (i + 1));
                let select = document.getElementById("contact_" + (i+1));
                let inputDelete = document.getElementById("delete_" + (i+1));

                divFormGroup.setAttribute("id","block_contact_" + i);

                select.setAttribute("name","contact_" + i);
                select.setAttribute("id","contact_" + i);

                inputDelete.setAttribute("id","delete_" + i);
                inputDelete.setAttribute("data-target","block_contact_" + i);
            }

            nbContacts.value = index ;

        }


    </script>
@endsection
