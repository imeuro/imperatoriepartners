// ip24.js

let img_counter = () => {
	const targetDiv = document.getElementById('entry-img');
	const galleryBlock = document.querySelector('.single .wp-block-gallery');

	if (targetDiv && galleryBlock){
		let PicNumber = galleryBlock.children.length;
		console.debug('PicNumber',PicNumber);

		targetDiv.innerHTML = PicNumber+' immagini';
		targetDiv.addEventListener('click', () => {
			galleryBlock.scrollIntoView({ behavior: 'smooth', block: 'center' }); 
		});
	}
}

let item_share = () => {
	const targetDiv = document.getElementById('entry-share');

	if (targetDiv && typeof(navigator.share) !== "undefined"){
	//if (targetDiv){
		//const resultPara = targetDiv;
		const shareData = {
			title: document.title,
			text: '',
			url: document.location.href,
		};
		targetDiv.innerHTML = '<a href="#">condividi</a>';
		targetDiv.addEventListener("click", async () => {
			try {
				await navigator.share(shareData);
				// resultPara.textContent = "MDN shared successfully";
			} catch (err) {
				// resultPara.textContent = `Error: ${err}`;
			}
		});
	}

}


img_counter();
item_share();