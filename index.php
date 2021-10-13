<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgendaBarber</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>
  <div id="app"></div>

  <script>
    new Vue({
        el: '#app',
        template: `
            <div ref="component">
                <section class="section">
                    <div class="container">
                        <h1 class="title">
                            {{ barberName }}
                        </h1>
                        <p class="subtitle">
                            Agende o horario do seu corte!
                        </p>

                    </div>
                </section>

                <section class="section">
                    <div class="container">


                    <nav class="pagination" role="navigation" aria-label="pagination">

                    <ul class="pagination-list">
                        <li>
                        <a class="pagination-link" v-on:click="anteriorMes" ><</a>
                        </li>
                        <li>
                        <a class="pagination-link" >{{meses[numeroMes].nome}}</a>
                        </li>
                        <li>
                        <a class="pagination-link" v-on:click="proximoMes">></a>
                        </li>
                    </ul>
                    </nav>




                    <table class="table is-bordered is-striped is-fullwidth">
                    <thead>                    
                        <tr>                 
                            <th v-for="dia in diasSemana" :key="dia.nome">
                                {{ dia.nome }}

                                
                            </th>                          
                        </tr>
             
                        <tr v-for='i in qtdLinhas':key='i' >
                            <td class="cell" v-for='j in 7':key='j' v-bind:id="(verificaData(i,j) ? ((i-1)*7+j)-(primeiroDiaMes % 7) : '')" v-on:click="selecionaData($event)" >                              
                            
 
                            {{verificaData(i,j) ? ((i-1)*7+j)-(primeiroDiaMes % 7) : ''}}
                                    
                                
                                
                              
                            </td>                          
                        </tr > 
                           
                    </thead>
                    </table>

                    
                    </div>
                </section>

                <section class="section">
                <div class="container">
                

                <h2 class="title ">Selecione o Horario</h2>
                <p class="subtitle">
                    Clique em agendar para marcar seu corte 
                </p>

                



                <table class="table is-bordered is-striped ">
                <thead>
                    <tr>
                        <th>Horario</th>
                                      
                            <th id="valorDataSelecionada">{{dadoAgendamento.dia}}/{{meses[numeroMes].nome}}</th> 
                            
                      

                    
                        

                    </tr>
                </thead>        
               
                        
                        
                            <tr v-for='i in 9':key='i' > <td>{{i+09}}:00</td><td><button class='button is-success is-fullwidth' v-bind:id=i+09 v-on:click="agendarHorario($event)">Agendar</button></td> </tr>
                        
                  
                
            
                
            </tbody>
            </table>






                </div>
            </section>



            <section class="section">
                <div class="container">

                    <div class="card" style="max-width:500px;">
                        <div class="card-content">
                            <form>
                            <h2 id="agendamento" class="title ">Agendamento</h2>
                            <h2 id="agendamentoData"class="title ">Dia: {{dadoAgendamento.dia}}/{{meses[numeroMes].nome}}</h2>
                            <h2 id="agendamentoHora"class="title ">Horario: {{dadoAgendamento.hora}}</h2>
                            
                            <hr/>
                            <p class="subtitle">
                            Para validar seu agendamento insira seu nome e email ou numero de telefone.
                            
                            </p>
                            <label class="label">Nome</label>
                            <div class="control">
                                <input class="input" required type="text" >
                            </div>
                            </br>
                            <label class="label">Telefone ou Email</label>
                            <div class="control">
                                <input class="input" required type="text" >
                            </div>
                            </br>
                            <div class="field is-grouped">

                            <div class="control">
                                <button class="button is-success is-light">Voltar</button>
                            </div>
                            <div class="control">
                                <button type="submit"class="button is-success">Agendar</button>
                            </div>
                            </div>
                            </form>  
                        </div>
                    </div>

                </div>
            </section>

        </div>

        `,
        data() {
            return {
            barberName: 'Salão do gui',
            meses: '',
            mesesAno: [
                { nome: 'Janeiro' },
                { nome: 'Fevereiro' },
                { nome: 'Março' },
                { nome: 'Abril' },
                { nome: 'Maio' },
                { nome: 'Junho' },
                { nome: 'Julho' },
                { nome: 'Agosto' },
                { nome: 'Setembro' },
                { nome: 'Outubro' },
                { nome: 'Novembro' },
                { nome: 'Dezembro' }
                ],
                diasSemana:[
                    { nome: 'Dom' },
                    { nome: 'Seg' },
                    { nome: 'Ter' },
                    { nome: 'Qua' },
                    { nome: 'Qui' },
                    { nome: 'Sex' },
                    { nome: 'Sab' }
                ],
                
                numeroMes: '',
                numeroAno: '',
                primeiroDiaMes: '',
                qtdDiaMes: '',
                qtdCelulasImprimir: '',
                qtdLinhasImprimir: '',
                diaHoje: '',
                cont : '',
                qtdCelulas : '',
                qtdLinhas : '',

                dadoAgendamento:{
                    hora: '',
                    dia: '',
                    mes: ''
                }

                
                
            }
        },
        methods: {        
            
            updateComponent(){
                this.$refs.component.open = true;
            },
            atualiza(){
                this.primeiroDiaMes = new Date(this.numeroAno,this.numeroMes, 1).getDay();
                this.qtdDiaMes = new Date(this.numeroAno,this.numeroMes+1,0).getUTCDate();
                this.qtdCelulasImprimir = this.primeiroDiaMes + this.qtdDiaMes;
                this.qtdLinhasImprimir = parseInt(this.qtdCelulasImprimir / 7);
                this.diaHoje =  new Date().getDate() ;
                this.qtdCelulas = (this.qtdCelulasImprimir) + (7-(this.qtdCelulasImprimir %7));
                this.qtdLinhas = this.qtdCelulas/7

             
            },
            anteriorMes(){
                if(this.numeroMes >=1){
                    this.numeroMes--;
                    this.atualiza();
                    this.updateComponent();
                    console.log(this.numeroMes)
                }
            },proximoMes() {
                if(this.numeroMes < this.meses.length-1){
                    this.numeroMes++;
                    this.atualiza();
                    this.updateComponent();
                    console.log(this.numeroMes)
                }
            
            },agendarHorario(){
                
                
                targetId = event.currentTarget.id;
                console.log(targetId);
                
                this.dadoAgendamento.hora = targetId+":00";


            }
            ,selecionaData(){
                
                targetId = event.currentTarget.id;
                if(targetId){
                    

                    element = event.currentTarget;
                    var x =document.getElementsByClassName("cell");        
                        var i;
                        for (i = 0; i < x.length; i++) {
                            x[i].style.backgroundColor = null;
                            x[i].style.color = "black";
                    }
                    element.style.backgroundColor = "#48c78e";
                    this.dadoAgendamento.dia = targetId;
                    
                    
                    
                }

            },
            verificaData(i,j){              
                
                    if((i-1)*7+j-(this.primeiroDiaMes % 7) >= 1 && (i-1)*7+j-(this.primeiroDiaMes % 7) <=this.qtdDiaMes){
                    return true;
                }else{
                    return false;
                }

                
            }
  
        },
        created() {
            this.numeroMes = 0;
            this.numeroAno = new Date().getFullYear();
            this.primeiroDiaMes = new Date(this.numeroAno,this.numeroMes, 1).getDay();
            this.qtdDiaMes = new Date(this.numeroAno,this.numeroMes+1,0).getUTCDate();
            this.qtdCelulasImprimir = this.primeiroDiaMes + this.qtdDiaMes;
            this.qtdLinhasImprimir = parseInt((this.qtdCelulasImprimir+7) / 7);
            this.diaHoje =  new Date().getDate() ;

            console.log(this.numeroMes);
            this.meses = this.mesesAno;
            
            this.meses = this.mesesAno.slice(new Date().getMonth(),this.mesesAno.length);

            this.qtdCelulas = (this.qtdCelulasImprimir) + (7-(this.qtdCelulasImprimir %7));

            console.log("qtdCelulas: ",this.qtdCelulas)

            this.qtdLinhas = this.qtdCelulas/7

            console.log("qtdLinhas: ",this.qtdLinhas)
            
        },
        computed: {

        },
        watch: {

        },
    })
  </script>
</body>
</html>