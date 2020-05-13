@extends('layouts.app')

@section('content')
<v-container class="mt-3">
<v-row>
    <v-col cols="12" sm="6" lg="3">
        <statistic title="Current Players" color="#FF1744">
            104
        </statistic>
    </v-col>
    <v-col cols="12" sm="6" lg="3">
        <statistic title="Players" color="#0091EA"></statistic>
    </v-col>
    <v-col cols="12" sm="6" lg="6">
        <donations></donations>
    </v-col>
</v-row>
</v-container>
@endsection
