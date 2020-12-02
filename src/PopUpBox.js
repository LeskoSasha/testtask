

function PopUpBox() {
	function ChangeEl() {
				document.getElementsByClassName("PopUpBox")[0].style.display="none";};
	function VerPrice(event) {
				var nombers = ['0','1','2','3','5','6','7','8','9','.'];
                
				
				if (!nombers.includes(event.key)){
				event.preventDefault();
				}
				}
  return (
   <div className="PopUpBox">
					<form onSubmit={ChangeEl}>
						<input className="inp_name" placeholder="Name of item" type="text"  />
						<input className="inp_price" placeholder="Price"  type="text"  onKeyPress={VerPrice}/>
					</form>
				</div>
  );
}

export default PopUpBox;
	
			