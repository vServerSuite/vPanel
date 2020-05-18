@extends('layouts.gateway')

@section('content')

<v-container class="fill-height primary darken-4" fluid>
    <v-row align="center" justify="center">
        @if($error != null)
        <v-alert type="error">
            {{ $error }}
        </v-alert>
        @else
        <onboarding-stepper 
        onboarding_id="{{ $id }}" 
        onboarding_mc_uuid="{{ $mc_uuid }}" 
        onboarding_discord_id="{{ $discord_id }}"
        ></onboarding-stepper>
        @endif
    </v-row>
</v-container>
@endsection