<style>
        :root {
            --line-border-fill: #3498db;
            --line-border-empty: #e0e0e0;
            --progress-zIndex: -1;
        }

        .progress-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            max-width: 100%;
            position: relative;
        }

        .progress-container::before {
            background-color: var(--line-border-empty);
            content: "";
            height: 4px;
            left: 0;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            z-index: var(--progress-zIndex);
        }

        .circle {
            font-size: 20px;
            background: #e0e0e0;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px 0 0 10px;
            transition: 0.3s all ease-in-out;
        }

        .circle__title {
            font-size: 12px;
            padding: 0 10px 0 10px;
            display: flex;
            align-items: center;
            border-radius: 0 10px 10px 0;
            background: #f8f7ff;
        }

        .circle.active {
            border-color: var(--line-border-fill);
            background: #c8b6ff;
            color: white;
        }

        .btn-pn {
            background-color: var(--line-border-fill);
            border: 0;
            border-radius: 6px;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            margin-top: 5px;
            padding: 8px 30px;
        }

        .btn-pn:active {
            transform: scale(0.98);
        }

        .btn-pn:focus {
            outline: 0;
        }

        .btn-pn:disabled {
            background-color: var(--line-border-empty);
            cursor: not-allowed;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
        
        .cont__input {
            display: flex;
            font-size: 28px;
            font-weight: 800;
        }

        .mock__up {
            width: 25%;
            padding: 20px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            object-fit: cover;
            background: #f7ede2;
        }

        .form-search {
            display: flex;
            font-size: 14px;
            gap: 10px;
        }

        .verify_gif {
            width: 150px;
            height: 150px;
        }

        .conn_verify {
            display: flex;
            width: 100%;
            justify-content: center;
            font-size: 16px;
        }

        .doc__gif {
            width: 50px;
        }

        .conn_title {
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        
        .mock__up img {
            width: 350px;
            object-fit: cover;
        }

        .card-radio {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .conn_cardr {
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
            display: flex;
            width: 100%;
        }

        .card-lable {
            width: 100%;
        }

        @media screen and (max-width: 992px) {
            .mock__up {
                width: 30%;
                padding: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f7ede2;
            }
            
            .mock__up img {
                width: 300px;
            }
        }

        @media screen and (max-width: 789px) {
            .progress-container {
                margin-top: 10px;
            }

            .mock__up {
                object-fit: scale-down;
                height: 150px;
                width: 100%;
                padding: 5px;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f7ede2;
            }

            .circle {
                border-radius: 10px;
            }


            .circle__title {
                display: none
            }

            
            .doc__gif {
                width: 50px;
            }

            .cont__input {
                display: block;
                font-size: 20px;
                font-weight: 600;
            }

            .conn_cardr {
                margin-top: 5px;
                display: block;
                width: 100%;
            }

            .form-search {
                display: block;
            }
             .input-bx {
                margin-top: 10px;
             }
        }
</style>