<style>
    /* RESET STYLES & HELPER CLASSES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    :root {
        --level-1: #8dccad;
        --level-2: #f5cc7f;
        --level-3: #7b9fe0;
        --level-4: #f27c8d;
        --black: black;
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    ol {
        list-style: none;
    }

    h2,
    h3 {
        margin-bottom: 0px;
    }

    .container__box {
        max-width: 1140px;
        padding: 0 10px;
        margin: 0 auto;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .rectangle {
        position: relative;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        border-radius: 15px;
    }

    img {
        width: 100%;
    }

    .user-img-box {
        width: 50px;
        height: 50px;
        border-radius: 50%;

    }

    .user-img-box>img {
        width: 100%;
        height: auto;
        object-fit: cover;
        object-position: center;
    }

    .d-flex {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: center;
    }

    .info h2 {
        font-size: 20px;
        font-weight: 600;
    }

    .info h3 {
        font-size: 15px;
        font-weight: 500;
    }

    .info__two {
        width: 65%;
        text-align: left;
    }

    /* LEVEL-1 STYLES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-1 {
        width: 50%;
        margin: 0 auto 40px;
        background: var(--level-1);
    }

    .level-1::before {
        content: "";
        position: absolute;
        top: 100%;
        left: calc(50% + 1px);
        transform: translateX(-50%);
        width: 2px;
        height: 20px;
        background: var(--black);
    }

    /* LEVEL-2 STYLES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-2-wrapper {
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .level-2-wrapper::before {
        content: "";
        position: absolute;
        top: -21px;
        left: calc(17% + -3px);
        width: calc(66% + 8px);
        height: 2px;
        background: var(--black);
    }

    .level-2-wrapper::after {
        display: none;
        content: "";
        position: absolute;
        left: -20px;
        bottom: -20px;
        width: calc(100% + 20px);
        height: 2px;
        background: var(--black);
    }

    .level-2-wrapper li {
        position: relative;
    }

    .level-2-wrapper>li::before {
        content: "";
        position: absolute;
        bottom: 100%;
        left: 50.3%;
        transform: translateX(-50.3%);
        width: 2px;
        height: 20px;
        background: var(--black);
    }

    .level-2 {
        width: 90%;
        margin: 0 auto 40px;
        background: var(--level-2);
    }

    .level-2::before {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 20px;
        background: var(--black);
    }

    .level-2::after {
        display: none;
        content: "";
        position: absolute;
        top: 50%;
        left: 0%;
        transform: translate(-100%, -50%);
        width: 20px;
        height: 2px;
        background: var(--black);
    }

    /* LEVEL-3 STYLES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-3-wrapper {
        position: relative;
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        grid-column-gap: 20px;
        width: 90%;
        margin: 0 auto;
    }

    .level-3-wrapper>li::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        transform: translate(-50%, -100%);
        width: 2px;
        height: 20px;
        background: var(--black);
    }

    .level-3 {
        margin-bottom: 20px;
        background: var(--level-3);
    }

    /* LEVEL-4 STYLES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    .level-4-wrapper {
        position: relative;
        width: 90%;
        margin-left: auto;
    }

    .level-4-wrapper::before {
        content: "";
        position: absolute;
        top: -21px;
        left: -20px;
        width: 2px;
        height: calc(100% + 20px);
        background: var(--black);
    }

    .level-4-wrapper li+li {
        margin-top: 20px;
    }

    .level-4 {
        font-weight: normal;
        background: var(--level-4);
    }

    .level-4::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0%;
        transform: translate(-100%, -50%);
        width: 20px;
        height: 2px;
        background: var(--black);
    }

    /* MQ STYLES
 –––––––––––––––––––––––––––––––––––––––––––––––––– */
    @media screen and (max-width: 700px) {
        .rectangle {
            padding: 20px 10px;
        }

        .level-1,
        .level-2 {
            width: 100%;
        }

        .level-1 {
            margin-bottom: 20px;
        }

        .level-1::before,
        .level-2-wrapper>li::before {
            display: none;
        }

        .level-2-wrapper,
        .level-2-wrapper::after,
        .level-2::after {
            display: block;
        }

        .level-2-wrapper {
            width: 90%;
            margin-left: 10%;
        }

        .level-2-wrapper::before {
            left: -20px;
            width: 2px;
            height: calc(100% + 40px);
        }

        .level-2-wrapper>li:not(:first-child) {
            margin-top: 50px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Organogram</h5>
                        <small>HRM / Organogram</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="container__box">
                                    <div class="level-1 rectangle d-flex">
                                        <div class="user-img-box">
                                            <img src="{{asset('images/user.png')}}" alt="user" />
                                        </div>
                                        <div class="info">
                                            <h2>CEO</h2>
                                            <h3>Jon Due</h3>
                                        </div>
                                    </div>
                                    <ol class="level-2-wrapper">
                                        <li>
                                            <div class="level-2 rectangle d-flex">
                                                <div class="user-img-box">
                                                    <img src="{{ asset('images/user.png') }}" alt="user" />
                                                </div>
                                                <div class="info info__two">
                                                    <h2>Director A</h2>
                                                    <h3>Jon Due</h3>
                                                </div>
                                            </div>
                                            <ol class="level-3-wrapper">
                                                <li>
                                                    <div class="level-3 rectangle d-flex">
                                                        <div class="user-img-box">
                                                            <img src="{{ asset('images/user.png') }}" alt="user" />
                                                        </div>
                                                        <div class="info info__two">
                                                            <h2>Manager A</h2>
                                                            <h3>Jon Due</h3>
                                                        </div>
                                                    </div>
                                                    <ol class="level-4-wrapper">
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person A</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person B</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person C</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person D</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                        <li>
                                            <div class="level-2 rectangle d-flex">
                                                <div class="user-img-box">
                                                    <img src="{{ asset('images/user.png') }}" alt="user" />
                                                </div>
                                                <div class="info info__two">
                                                    <h2>Director B</h2>
                                                    <h3>Jon Due</h3>
                                                </div>
                                            </div>
                                            <ol class="level-3-wrapper">
                                                <li>
                                                    <div class="level-3 rectangle d-flex">
                                                        <div class="user-img-box">
                                                            <img src="{{ asset('images/user.png') }}" alt="user" />
                                                        </div>
                                                        <div class="info info__two">
                                                            <h2>Manager B</h2>
                                                            <h3>Jon Due</h3>
                                                        </div>
                                                    </div>
                                                    <ol class="level-4-wrapper">
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person A</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person B</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person C</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person D</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                        <li>
                                            <div class="level-2 rectangle d-flex">
                                                <div class="user-img-box">
                                                    <img src="{{ asset('images/user.png') }}" alt="user" />
                                                </div>
                                                <div class="info info__two">
                                                    <h2>Director C</h2>
                                                    <h3>Jon Due</h3>
                                                </div>
                                            </div>
                                            <ol class="level-3-wrapper">
                                                <li>
                                                    <div class="level-3 rectangle d-flex">
                                                        <div class="user-img-box">
                                                            <img src="{{ asset('images/user.png') }}" alt="user" />
                                                        </div>
                                                        <div class="info info__two">
                                                            <h2>Manager C</h2>
                                                            <h3>Jon Due</h3>
                                                        </div>
                                                    </div>
                                                    <ol class="level-4-wrapper">
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person A</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person B</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person C</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="level-4 rectangle d-flex">
                                                                <div class="user-img-box">
                                                                    <img src="{{ asset('images/user.png') }}"
                                                                        alt="user" />
                                                                </div>
                                                                <div class="info info__two">
                                                                    <h2>Person D</h2>
                                                                    <h3>Jon Due</h3>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>

<script>
    $("body").addClass("sidebar-collapse");
</script>
