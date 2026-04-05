 <script>
   const products = [
     { id:1, name:'Qramofon №1', type:'gramofon', price:200, img:'https://i.pinimg.com/736x/d7/c4/94/d7c494113e04cda52a05ef586f1206df.jpg' },
     { id:2, name:'Qramofon №2', type:'gramofon', price:250, img:'https://i.pinimg.com/736x/6f/c4/24/6fc424bfdb789673251d228bc93e4ca1.jpg' },
     { id:3, name:'Qramofon №3', type:'gramofon', price:200, img:'https://i.pinimg.com/736x/c4/9b/c2/c49bc2c64f9582a7a43e30b0681e6404.jpg' },
     { id:4, name:'Qramofon №4', type:'gramofon', price:300, img:'https://i.pinimg.com/1200x/68/fd/b5/68fdb594cf057e7ad091164deafb80dd.jpg' },
     { id:5, name:'Qramofon №5', type:'gramofon', price:800, img:'https://i.pinimg.com/736x/a9/01/aa/a901aaf73486ef59f268091714dc455e.jpg' },
     { id:6, name:'Duman — Seni Kendime Sakladim', type:'vinyl', price:150, img:'https://m.media-amazon.com/images/I/71BdAHTysTL._AC_UF1000,1000_QL80_.jpg' },
     { id:7, name:'Duman — Plak', type:'vinyl', price:90, img:'https://www.ozhizo.com.tr/wp-content/uploads/2020/12/Satilik-Plak-Duman-Eski-Koprunun-Altinda-Plak-
     { id:8, name:'Cem Karaca — Plak', type:'vinyl', price:70, img:'https://cdn03.ciceksepeti.com/cicek/kcm1172494-1/L/cem-karaca-olumsuzler-1-plak-kcm1172494-1-1
     { id:9, name:'Patrick Watson — LP', type:'vinyl', price:300, img:'https://www.secretcityrecords.com/cdn/shop/files/Patrick_Watson_JTLDM_LP_Packshot_Black.jpg
   ];
   let cart = {};
   function renderProducts() {
     document.getElementById('productsGrid').innerHTML = products.map(p => `
       <div class="product">
         <img src="${p.img}" alt="${p.name}">
         <span class="badge badge-${p.type}">${p.type === 'gramofon' ? 'Qramofon' : 'Vinyl'}</span>
         <h3>${p.name}</h3>
         <div class="price">${p.price} AZN</div>
         <button class="add-btn" onclick="addToCart(${p.id})">Səbətə əlavə et</button>
       </div>
     `).join('');
   }
   function addToCart(id) {
     cart[id] = (cart[id] || 0) + 1;
     updateCart();
   }
   function changeQty(id, delta) {
     cart[id] = (cart[id] || 0) + delta;
     if (cart[id] <= 0) delete cart[id];
     updateCart();
   }
   function updateCart() {
     const count = Object.values(cart).reduce((s, q) => s + q, 0);
     const total = Object.keys(cart).reduce((s, id) => {
       const p = products.find(x => x.id == id);
       return s + (p ? p.price * cart[id] : 0);
     }, 0);
     const countEl = document.getElementById('cartCount');
     countEl.textContent = count;
     countEl.style.display = count > 0 ? 'flex' : 'none';
     document.getElementById('cartTotal').textContent = total + ' AZN';
     const itemsEl = document.getElementById('cartItems');
     if (count === 0) {
       itemsEl.innerHTML = '<div class="cart-empty">Səbət boşdur</div>';
       return;
     }
     itemsEl.innerHTML = Object.keys(cart).map(id => {
       const p = products.find(x => x.id == id);
       return `
         <div class="cart-item">
           <img src="${p.img}" alt="${p.name}">
           <div class="cart-item-info">
             <div class="cart-item-name">${p.name}</div>
             <div class="cart-item-price">${p.price} AZN</div>
           </div>
           <div class="cart-item-qty">
             <button class="qty-btn" onclick="changeQty(${p.id},-1)">−</button>
             <span class="qty-num">${cart[id]}</span>
             <button class="qty-btn" onclick="changeQty(${p.id},1)">+</button>
           </div>
         </div>`;
     }).join('');
   }
   function openCart() {
     document.getElementById('cartPanel').classList.add('open');
     document.getElementById('overlay').classList.add('show');
   }
   function closeCart() {
     document.getElementById('cartPanel').classList.remove('open');
     document.getElementById('overlay').classList.remove('show');
   }
   function showPage(page) {
     document.getElementById('page-home').style.display = page === 'home' ? 'flex' : 'none';
     document.getElementById('page-products').style.display = page === 'products' ? 'block' : 'none';
     document.getElementById('nav-home').classList.toggle('active', page === 'home');
     document.getElementById('nav-products').classList.toggle('active', page === 'products');
   }
   function sifarisVer() {
     if (Object.keys(cart).length === 0) { alert('Səbət boşdur!'); return; }
     const mehsullar = Object.keys(cart).map(id => {
       const p = products.find(x => x.id == id);
       return { id: p.id, ad: p.name, miqdar: cart[id], qiymet: p.price };
     });
     const total = mehsullar.reduce((s, m) => s + m.qiymet * m.miqdar, 0);
     document.getElementById('xulaseMehsullar').innerHTML = mehsullar.map(m => `
       <div class="xulase-item">
         <span>${m.ad} x${m.miqdar}</span>
         <span>${m.qiymet * m.miqdar} AZN</span>
       </div>`).join('');
     document.getElementById('xulaseCemi').textContent = total + ' AZN';
     ['kartAd','kartNo','kartTarix','kartCvv'].forEach(id => document.getElementById(id).value = '');
     document.getElementById('kartFormHisse').style.display = 'block';
     document.getElementById('ugurEkran').style.display = 'none';
     closeCart();
     document.getElementById('kartModal').classList.add('show');
   }
   function kartModalBag() {
     document.getElementById('kartModal').classList.remove('show');
   }
   function odenisEt() {
     const ad    = document.getElementById('kartAd').value.trim();
     const no    = document.getElementById('kartNo').value.trim();
     const tarix = document.getElementById('kartTarix').value.trim();
     const cvv   = document.getElementById('kartCvv').value.trim();
     if (!ad || no.replace(/\s/g,'').length < 16 || tarix.length < 5 || cvv.length < 3) {
       alert('Butun xanalari doldurun!');
       return;
     }
     const mehsullar = Object.keys(cart).map(id => {
       const p = products.find(x => x.id == id);
       return { id: p.id, ad: p.name, miqdar: cart[id], qiymet: p.price };
     });
     const total = mehsullar.reduce((s, m) => s + m.qiymet * m.miqdar, 0);
     fetch('sifaris.php', { // Yanındakı fayla müraciət edirik
   method: 'POST',
   headers: { 'Content-Type': 'application/json' },
   body: JSON.stringify({ 
       sebetMehsullar: mehsullar, 
       umumiMebleg: total, 
       kart_ad: ad, 
       kart_nomre: no, 
       kart_tarix: tarix // bura diqqət et, 'larix' deyil 'tarix' olsun
   })
)
     .then(res => res.json())
     .then(data => {
       if (data.success) {
         document.getElementById('kartFormHisse').style.display = 'none';
         document.getElementById('ugurEkran').style.display = 'block';
         document.getElementById('ugurMetn').textContent = 'Sifaris №' + data.sifaris_id + ' — ' + total + ' AZN odendi.';
         cart = {};
         updateCart();
       } else {
         alert('Xeta: ' + data.mesaj);
       }
     })
     .catch(() => alert('XAMPP islemir! Apache ve MySQL-i yoxlayin.'));
   }
   function kartNoFormat(input) {
     let v = input.value.replace(/\D/g,'').substring(0,16);
     v = v.match(/.{1,4}/g)?.join(' ') || v;
     input.value = v;
   }
   function tarixFormat(input) {
     let v = input.value.replace(/\D/g,'').substring(0,4);
     if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
     input.value = v;
   }
   renderProducts();
 </script>
