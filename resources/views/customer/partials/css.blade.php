<link rel="stylesheet"  href="{{asset('plugins/fontawesome-pro/css/all.min.css')}}"/>
<link rel="stylesheet"  href="{{asset('css/main.css')}}"/>
<style>
    /*==================Preloader======================*/
    /* The Loader */
    #loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100000;
        overflow: hidden;
    }
    .no-js #loader-wrapper {
        display: none;
    }
    #loader {
        display: block;
        position: relative;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #16a085;
        -webkit-animation: spin 1.7s linear infinite;
        animation: spin 1.7s linear infinite;
        z-index: 11;
    }
    #loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #e74c3c;
        -webkit-animation: spin-reverse 0.6s linear infinite;
        animation: spin-reverse 0.6s linear infinite;
    }
    #loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }
    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-webkit-keyframes spin-reverse {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(-360deg);
        }
    }

    @keyframes spin-reverse {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(-360deg);
            transform: rotate(-360deg);
        }
    }

    #loader-wrapper .loader-background {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.767);
        z-index: 10;
    }

    #loader-wrapper .loader-section.section-left {
        left: 0;
    }

    #loader-wrapper .loader-section.section-right {
        right: 0;
    }

    /* Loaded styles */
    .loaded #loader-wrapper .loader-section.section-left {
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .loaded #loader-wrapper .loader-section.section-right {
        -webkit-transform: translateX(100%);
        transform: translateX(100%);
        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .loaded #loader {
        opacity: 0;
        -webkit-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }

    .loaded #loader-wrapper {
        visibility: hidden;
        /* -webkit-transform: translateY(-100%); */
        /* transform: translateY(-100%); */
        opacity: 0;
        -webkit-transition: all 0.2s 0.5s ease-out;
        transition: all 0.2s 0.5s ease-out;
    }

</style>
<style>
    .zalo-share-button{
        margin-top: 10px;
        background: #5AB5F7;
        border-radius: 3px;
        color: white;
        font-size: 15px;
        cursor: pointer;
        text-align: center;
        padding: 10px 0;
    }
    .fb-share-button{
        width: 100%;
    }
    .fb-share-button > span {
        width: 100% !important;
    }

    .fb-share-button iframe {
        width: 100% !important;
    }
</style>
<script>

    function hello(){
        console.log('hello');
    }
</script>
@yield('css')
