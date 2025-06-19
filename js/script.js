  const carrinho = [];

  function renderCarrinho() {
    const lista = document.getElementById('carrinho-itens');
    const vazio = document.getElementById('carrinho-vazio');
    const totalSpan = document.getElementById('preco-total');
  
    lista.innerHTML = '';
  
    if (carrinho.length === 0) {
      vazio.style.display = 'block';
    } else {
      vazio.style.display = 'none';
  
      carrinho.forEach((prod, index) => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `
          ${prod.nome}
          <div class="d-flex align-items-center gap-2">
            <span class="preco">${prod.preco} créditos</span>
            <button class="btn btn-sm btn-danger" data-index="${index}">🗑️</button>
          </div>
        `;
        lista.appendChild(li);
      });
  
      // Adiciona eventos aos botões de remover
      lista.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', () => {
          const index = btn.dataset.index;
          carrinho.splice(index, 1);
          renderCarrinho(); // Re-renderiza
        });
      });
    }
  
    // ✅ Sempre recalcula o total
    const total = carrinho.reduce((soma, prod) => {
      const valor = parseFloat(prod.preco.replace(',', '.'));
      return soma + (isNaN(valor) ? 0 : valor);
    }, 0);
  
    totalSpan.textContent = `${total.toFixed(2).replace('.', ',')} créditos`;
  }
  
  document.querySelectorAll('.add-to-cart').forEach(botao => {
    botao.addEventListener('click', e => {
      e.preventDefault();
      const nome = botao.dataset.nome;
      const preco = botao.dataset.preco;

      carrinho.push({ nome, preco });
      renderCarrinho();

      // abre o carrinho automaticamente
      const offcanvas = new bootstrap.Offcanvas('#offcanvasWithBothOptions');
      offcanvas.show();
    });
  });

  renderCarrinho();
