@extends('layouts.gateway')

@section('content')
    <v-container
        class="fill-height primary darken-4"
        fluid
    >
        <v-row
            align="center"
            justify="center"
        >
            <register-form></register-form>
        </v-row>
    </v-container>
@endsection
