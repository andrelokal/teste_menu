// Url da API Lumen
var $HOST_API = 'http://localhost:8000';

var $id = document.querySelector('#id')
var $status = document.querySelector('#status')
var $valor = document.querySelector('#valor')
var $nome = document.querySelector('#nome')
var $sobrenome = document.querySelector('#sobrenome')
var $email = document.querySelector('#email')
var $btnUpdateOrder = document.querySelector('#btn-update-order')
var $collapseDetalhesCliente = document.querySelector('#collapse-detalhes-cliente')

// form new pedido
var $selectNewCliente = document.querySelector('#select-new-cliente')
var $inputNewStatus = document.querySelector('#input-new-status')
var $inputNewValor = document.querySelector('#input-new-valor')

// form new cliente
var $inputNewClienteNome = document.querySelector(
    '#input-new-cliente-nome'
)
var $inputNewClienteSobrenome = document.querySelector(
    '#input-new-cliente-sobrenome'
)
var $inputNewClienteEmail = document.querySelector(
    '#input-new-cliente-email'
)

function fnOpenModalNewClient() {
    $('#modal-new-client').modal('show')
}

function fnOpenModalNewOrder() {
    $('#modal-new-order').modal('show')
    $inputNewStatus.value = 'new'
    fnRefreshClient()
}

function fnRefreshClient() {
    axios({
        method: 'get',
        url: $HOST_API+'/clientes',
    }).then(function (res) {
        let option = []
        const clients = res.data
        option.push(`<option selected disabled>Selecione um Cliente</option>`)
        clients.map((client) => {
            option.push(`<option value="${client.id}">`)
            option.push(client.nome + ' ' + client.sobrenome)
            option.push(`</option>`)
        })
        $selectNewCliente.innerHTML = option.join('')
    })
}

function fnRefreshOrder() {
    axios({
        method: 'get',
        url: $HOST_API+'/pedidos',
    }).then(function (res) {
        const order = res.data
        let hContent = ``
        order.map((item) => {
            hContent += `<tr>
                    <th scope="row">${item.id}</th>
                    <td>${item.cliente.nome} ${item.cliente.sobrenome}</td>
                    <td>${item.status}</td>
                    <td>${item.valor}</td>
                    <td class="text-right">
                        <div class="btn-group">
                          <button type="button" class="btn btn-secondary dropdown-toggle mr-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Opções
                          </button>
                          <div class="dropdown-menu">
                            <a
                              class="dropdown-item"
                              href="javascript:"
                              onclick="fnOpenDetail('update', ${item.id}, '${item.status}', '${item.valor}', '${item.cliente.nome}', '${item.cliente.sobrenome}', '${item.cliente.email}')"
                            >
                              Alterar
                            </a>
                            <a
                              class="dropdown-item"
                              href="javascript:"
                              onclick="fnDeleteOrder(${item.id})"
                            >
                              Excluir
                            </a>
                          </div>
                        </div>
                        <button
                            class="btn btn-primary"
                            data-toggle="modal"
                            onclick="fnOpenDetail('detalhe', ${item.id}, '${item.status}', '${item.valor}', '${item.cliente.nome}', '${item.cliente.sobrenome}', '${item.cliente.email}')"
                        >Detalhes</button>
                    </td>
                </tr>`
            document.getElementById('tbody').innerHTML = hContent
        })
        fnChart(order)
    })

    fnResetForm()
}

function fnResetFormNewClient() {
    $inputNewClienteNome.value = ''
    $inputNewClienteSobrenome.value = ''
    $inputNewClienteEmail.value = ''
}

function fnResetFormNewOrder() {
    $inputNewValor.value = ''
    $inputNewStatus.value = 'new'
    $selectNewCliente.selectedIndex = 0
}

function fnSaveNewOrder() {
    if ($selectNewCliente.value === '') {
        $('#select-new-cliente').focus()
        return
    }
    if ($inputNewValor.value === '') {
        $('#input-new-valor').focus()
        return
    }
    axios({
        method: 'post',
        url: $HOST_API+'/pedidos',
        data: {
            status: $inputNewStatus.value,
            id_cliente: $selectNewCliente.value,
            valor: $inputNewValor.value,
        },
    }).then(function (res) {
        const {status, data} = res
        if (status === 201) {
            alert('Pedido cadastrado com sucesso.')
            fnResetFormNewOrder()
            fnCloseModal('modal-new-order')
            fnRefreshOrder()
        }
    })
}

function fnSaveNewClient() {
    if ($inputNewClienteNome.value === '') {
        $('#input-new-cliente-nome').focus()
        return
    }
    if ($inputNewClienteSobrenome.value === '') {
        $('#input-new-cliente-sobrenome').focus()
        return
    }
    if ($inputNewClienteEmail.value === '') {
        $('#input-new-cliente-email').focus()
        return
    }
    axios({
        method: 'post',
        url: $HOST_API+'/clientes',
        data: {
            nome: $inputNewClienteNome.value,
            sobrenome: $inputNewClienteSobrenome.value,
            email: $inputNewClienteEmail.value,
        },
    }).then(function (res) {
        const {status, data} = res
        if (status === 201) {
            alert('Cliente cadastrado com sucesso.')
            fnResetFormNewClient()
            fnCloseModal('modal-new-client')
        }
    })
}

function fnResetForm() {
    $collapseDetalhesCliente.classList.remove('show')
    $id.value = ''
    $status.value = ''
    $valor.value = ''
    $nome.textContent = ''
    $sobrenome.textContent = ''
    $email.textContent = ''
    $btnUpdateOrder.style.display = 'none'
}

function fnCloseModal(id) {
    $(`#${id}`).modal('hide')
}

function fnOpenDetail(type, id, status, valor, nome, sobrenome, email) {
    $collapseDetalhesCliente.classList.remove('show')
    $id.value = id
    $status.value = status
    $valor.value = valor
    $nome.textContent = nome
    $sobrenome.textContent = sobrenome
    $email.textContent = email
    $('#modal-select-order').modal('show')
    if (type === 'detalhe') {
        $id.disabled = true
        $status.disabled = true
        $valor.disabled = true
        $btnUpdateOrder.style.display = 'none'
    } else if (type === 'update') {
        $id.disabled = true
        $status.disabled = false
        $valor.disabled = false
        $btnUpdateOrder.style.display = 'block'
    }
}

function fnUpdateOrder(id_client) {
    var $id = document.querySelector('#id')
    var $status = document.querySelector('#status')
    var $valor = document.querySelector('#valor')
    axios({
        method: 'put',
        url: `http://localhost:8000/pedidos`,
        data: {
            id: $id.value,
            status: $status.value,
            valor: $valor.value,
        },
    }).then(function (res) {
        const {status, data} = res
        if (status === 200) {
            alert('Pedido alterado com sucesso.')
            fnCloseModal('modal-select-order')
            fnRefreshOrder()
        }
    })
}

function fnDeleteOrder(id) {
    axios({
        method: 'delete',
        url: `http://localhost:8000/pedidos/${id}`,
    }).then(function (res) {
        const {status, data} = res
        if (status === 200) {
            alert('Pedido deletado com sucesso.')
            fnRefreshOrder()
        }
    })
}

function fnChart(data) {
    count = 1
    var chart1 = 0
    var chart2 = 0
    var chart3 = 0
    for (let i in data) {
        switch (data[i].status) {
            case 'new':
                chart1 = chart1 + data[i].valor
                break
            case 'pending':
                chart2 = chart2 + data[i].valor
                break
            case 'delivered':
                chart3 = chart3 + data[i].valor
                break
        }
        count++
    }

    var options = {
        animationEnabled: true,
        title: {
            text: 'Gráfico de Pedidos',
        },
        axisY: {
            title: 'Crescimento (em Reais)',
            suffix: 'R$',
            includeZero: false,
        },
        axisX: {
            title: 'Status de Pedido',
        },
        data: [
            {
                type: 'column',
                yValueFormatString: '#,##0.0#' % '',
                dataPoints: [
                    {label: 'Novos', y: chart1},
                    {label: 'Pendentes', y: chart2},
                    {label: 'Entregues', y: chart3},
                ],
            },
        ],
    }
    $('#chartContainer').CanvasJSChart(options)
}

fnRefreshOrder()