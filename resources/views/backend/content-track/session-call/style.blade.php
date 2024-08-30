<style>
	.navs-carousel .owl-nav button {
		width: 30px;
		height: 30px;
		line-height: 28px !important;
		font-size: 20px !important;
		border-radius: 50% !important;
		background-color: rgba(85, 110, 230, 0.25) !important;
		color: #556ee6 !important;
		margin: 4px 8px !important;
	}

	.owl-prev {
    width: 15px;
    height: 300px;
    position: absolute;
    top: 60%;
    left: 0px;
    display: block !important;
    border:0px solid black;
    font-size: xx-large !important;
  }

  .owl-next {
    width: 15px;
    height: 300px;
    position: absolute;
    top: 60%;
    right: 15px;
    display: block !important;
    border:0px solid black;
    font-size: xx-large !important;
  }
  .owl-prev i, .owl-next i {transform : scale(1,6); color: #ccc;}

</style>

<style>
  /* width */
  ::-webkit-scrollbar {
    width: 10px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1; 
  }
  
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888; 
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555; 
  }
</style>

<style>
	/* Variable Declaration */
	:root {
		--shadow: #f1f1f1;
		--bgColor: #f1f1f1;
		--ribbonColor: #077918;
	}

	/* The Ribbon */
	.ribbon-page {
		width: 35px;
		height: 30px;
		background-color: var(--ribbonColor);
		position: absolute;
		right: 15px;
		top: -350px;
		animation: drop forwards 0.8s 1s cubic-bezier(0.165, 0.84, 0.44, 1);
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.ribbon-page:before {
		content: '';
		position: absolute;
		z-index: 2;
		left: 0;
		bottom: -14.5px;
		border-left: 17.9px solid var(--ribbonColor);
		border-right: 17px solid var(--ribbonColor);
		border-bottom: 15px solid transparent;
	}

	.ribbon-text {
		margin: 0;
		font-size: 10px;
		font-weight: bold;
		color: var(--shadow);
		/* สีเงาที่กำหนด */
	}

	@keyframes drop {
		0% {
			top: -350px;
		}

		100% {
			top: 0;
		}
	}
</style>

<style>
  .custom-popover {
    --bs-popover-border-color: var(--bs-warning);
    --bs-popover-header-bg: var(--bs-warning);
    --bs-popover-header-color: var(--bs-white);
    --bs-popover-body-padding-x: 1rem;
    --bs-popover-body-padding-y: .5rem;
  }
</style>

<style>
	.overlay {
		position: absolute;
		top: 10%;
		left: 50%;
		transform: translate(-50%, -50%);
		color: red;
		font-size: 1em;
		font-weight: bold;
		text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
		pointer-events: none;
	}
</style>