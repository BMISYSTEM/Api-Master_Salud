function TPLANTIO_CorteF.Grava : boolean;
var
   vt,
   area_rest : real;
   bcompra : boolean;
   v1,
   v2,
   upag : integer;
   valor_custo : real;
   scodigo_processo,
   perro,
   strMsg,
   strsql : string;
   lt_CDS           : TClientDataSet;
   sMsg: WideString;
   bNuevo : Boolean;
   strEquipo : String;
begin
   Grava := false;

   // Edilson 17/10/2023
   if LiquidadoEnSicap then
      Exit;

   mmTr.Lines.Clear;
   if not datData.DataValida then
      Exit;

   if datData.Date = 0 then
      begin
         BMsg.Texto(BMsg.Fix('Informe a Data', 'Informe la Fecha.', 'Inform the Date'));
         Exit;
      end;

   if Dt_FH_Ejec.Visible then
      if (Dt_FH_Ejec.Date = 0) or (not Dt_FH_Ejec.DataValida) then
          begin
             BMsg.Error(BMsg.Fix('Informe a Data ejecucion','Informe la fecha de ejecución','Inform the Date of execution'));
             Exit;
          end;

   if Trim(oper.Text) = '' then
      begin
         BMsg.Error(BMsg.Fix('Atividade deve ser especificada.',
                             'La Actividad debe ser especificada.',
                             'Activity must be specified.') );
         exit;
      end;

   if not(Reabre_OSOP_Encerrada) and (bOperOS) then
      if Verifica_Op_Enc(Os.Valor,Trim(oper.Text),'',false) then
         begin
            BMsg.Error(BMsg.Fix('Atividade encerrada. Não é permitido incluir/alterar.',
                                'Actividad cerrada. No es permitido añadir/cambiar.',
                                'Activity closed. Not allowed to include/change.') );
            exit;
         end;

   if OS_MesAnoCustoFechado(datData.Date, GUsina, CulturaOS(GUsina, OS.Valor)) then
      Exit;

   bcompra := chcompra.checked;
   if BConversao.MStrToFloat( num.text ) = 0  then
      begin
         BMsg.Error( BMsg.Fix('Número do apontamento inválido','Número del apuntamiento inválido','Invalid appointment number') );
         exit;
      end;
   if BConversao.MStrToFloat( ton.text ) <= 0  then
      begin
         BMsg.Error( BMsg.Fix( 'TONELADAS inválidas' , 'TONELADAS inválidas.' , 'TONELADAS not valid'),  'No pueden ser cero ni negativa.' );
         exit;
      end;
   if area.Visible and area.enabled then
      if BConversao.MStrToFloat( area.text ) <= 0  then
         begin
            BMsg.Error( BMsg.Fix( 'AREA inválida' , 'AREA inválida.' , 'TONELADAS not valid'),  'No pueden ser cero ni negativa.' );
            exit;
         end;
   if (forned.text <> '') and
      (edtfazo.text <> '') then
      begin
         BMsg.Error( BMsg.Fix('Não pode ser informada ','No puede ser informado ','Cannot be informed ') + GNomeFaz + BMsg.Fix(' e Fornecedor no mesmo apontamento',' y Proveedor en el mismo apuntamiento',' and Supplier in the same appointment') );
         exit;
      end;

   if not ValidaDATA then
      exit;

   if not ValidaVAR then
      exit;

   if not(OS_ChecaAtividade(os.Valor,Trim(oper.Text),Trim(cjopered.Text),bOperOS,FbolInsereAtivOS,datData.Date)) then
      exit;

   if not Valida_MO_Lib(datData.date, '', 'SIE', strMsg, edtSetO.Text, edtFazO.Text) then
      begin
         BMsg.Error(strMsg);
         exit;
      end;

   if bcompra then
      begin
         if not ValidaForn then
            exit;
      end
   else
      begin
         if Lib.Visible then
            if not ValidaLIB then
               exit;
         if not ValidaOS then
            exit;
         if not ValidaTAL then
            exit;
         if not ValidaArea then
            exit;
         if Lib.Visible then
            if Lib.Text <> '' then
               begin
                  area_rest := Damearearest;

                  vt := BConversao.MRound( BConversao.MStrToFloat( area.text ), 3 );
                  v1 := Trunc( vt * 1000 );
                  vt := BConversao.MRound( area_rest, 3 );
                  v2 := Trunc( vt * 1000 );

                  if v1 > v2 then
                     begin
                        if BMsg.YesNo( BMsg.Fix('Atenção: Área Cortada (','Atención: Área Cortada (','Attention: Cutted Area (') + area.text + ') > Área Restante ( ' +
                           BConversao.M3FloatToStr(area_rest) + BMsg.Fix('). Confirma gravação?','). Confirma grabación?','). Confirm recording?'), '[Liberada= ' + BConversao.M3FloatToStr(area_lib) + ' Otros registros= ' + BConversao.M3FloatToStr(area_corte) +']' ) = idNo then
                        exit;
                     end;
               end;
      end;

   If Trim( ed_safra.Text ) = '' Then
      Begin
         BMsg.Error(TBSiagriNomenclatura.GetInstance.NomePeriodo.Singular +
            BMsg.Fix(' não informada', ' no informada', ' not informed'));
         If ed_safra.CanFocus Then
             ed_safra.SetFocus;
         Exit;
      End
   Else
      Begin
         ed_safraExit( Self );
         If Trim( lb_safra.Caption ) = '' Then
         Begin
           BMsg.Error(TBSiagriNomenclatura.GetInstance.NomePeriodo.Singular +
              BMsg.Fix(' inválida!', ' inválida!', ' invalid!'));
           If ed_safra.CanFocus Then
               ed_safra.SetFocus;
           Exit;
         End;
      End;

   if TratoEd.Visible then
      begin
         if TratoEd.Text = '' then
            begin
               BMsg.Texto( BMsg.Fix('Informe o ', 'Informe el ', 'Type the ') + GNomeServicio );
               if TratoEd.CanFocus then
                  TratoEd.SetFocus;
               Exit;
            end;

         if LbTrato.Caption = '' then
            begin
               BMsg.Error( GNomeServicio + BMsg.Fix(' não encontrado.', ' no encontrato.', ' not found.') );
               if TratoEd.CanFocus then
                  TratoEd.SetFocus;
               Exit;
            end;

         with QQ do
            begin
               Close;
               Sql.Clear;
               Sql.Add('SELECT TRATO              ');
               Sql.Add('  FROM OPERAGR_TRATO      ');
               Sql.Add(' WHERE OPERAGR = :OPERAGR ');
               Sql.Add('   AND TRATO   = :TRATO   ');
               ParamByName('OPERAGR').AsString := Oper.Text;
               ParamByName('TRATO'  ).AsString := TratoEd.Text;
               Open;

               if isempty then
                  begin
                     BMsg.Error( GNomeServicio + ' '+ TratoEd.Text + ' ' +
                                 BMsg.Fix( 'não permitido para essa atividade',
                                           'no permitido para esa actividad',
                                           'not allowed for this activity' ) +
                                 ' [' + Oper.Text + ']' );
                     if TratoEd.CanFocus then
                        TratoEd.SetFocus;

                     Close;
                     Exit;
                  end;

               Close;
            end;
      end;

   if edtEmpresa.Visible then
      begin
         edtEmpresaExit(edtEmpresa);

         if lblEmpresa.Caption = '' then
            begin
               BMsg.Error( BMsg.Fix('Prestador de serviço inválido!', 'Prestador de servicio inválido!', 'Invalid Service Provider!'));
               edtEmpresa.SetFocus;
               exit;
            end;

         if not EmpresaActiva( edtEmpresa.Text ) then
           Exit;

         // Edilson 03/10/2023 - Validar contrato de prestación de servicios
         strEquipo := '';

         if Not CheckContratoPrestador( edtEmpresa.Text,
                                        CjOperEd.Text,
                                        Oper.Text,
                                        strEquipo,
                                        edtSetO.Text,
                                        edtFazO.Text,
                                        edtLotO.Text,
                                        edtTalO.Text,
                                        TratoEd.Text,
                                        OS.Text,
                                        datData.Date,
                                        strMsg ) then
            begin
               BMsg.Error(strMsg);
               Exit
            end;
      end;

   if edtFeixes.Visible and (BConversao.MStrToFloat( ton.text )<=0) then
      begin
         if BConversao.MStrToFloat(edtFeixes.Text) <= 0 then
            begin
               BMsg.Error( BMsg.Fix('Número de ' + GNomePaqueteS + ' inválido',
                                    'Número de ' + GNomePaqueteS + ' inválido',
                                    'Invalid Number of ' + GNomePaqueteS));
               edtFeixes.SetFocus;
               exit;
            end;

         if BConversao.MStrToFloat(edtPeso_Feixe.Text) <= 0 then
            begin
               BMsg.Error( BMsg.Fix('Peso do ' + GNomePaquete + ' inválido',
                                    'Peso del ' + GNomePaquete + ' inválido',
                                    'Invalid weight of the ' + GNomePaquete));
               edtPeso_Feixe.SetFocus;
               exit;
            end;

         if BConversao.MStrToFloat( ton.text ) <= 0  then
            begin
               BMsg.Error( BMsg.Fix( 'TONELADAS inválidas' , 'TONELADAS inválidas.' , 'TONELADAS not valid' ), 'No pueden ser cero ni negativas.');
               exit;
            end;
      end;

   if not Valida_Variedade_Talhao(edtSetO.Text, edtFazO.Text, edtLotO.Text, edtTalO.Text, Vared.Text) then
      exit;

   if bolFin then
      begin
         if bolFinN4 and chkFin.Checked then
            begin
               if BMsg.YesNo( BMsg.Fix( 'Vc marcou o Fim do Corte. Vamos proceder com o fechamento do(a) ' + GNomeTal + '. Tem certeza?',
                                        'Usted marco el Fin del Corte. Vamos a proceder con el cierre del(a) ' + GNomeTal + '. Está seguro?') ) = idNo then
                              exit;
            end;
      end;

   upag := 0;

   FValorizacaoAtividade.SetDefault; //Default_CustoRef;
   case Tipo_Valorizacao of
      0 : UNID_PAG := DameUM(UM_TON);
      1 : UNID_PAG := DameUM(UM_FEIXE);
      2 : UNID_PAG := DameUM(UM_METROS);
      3 : UNID_PAG := DameUM(UM_HA);
   end;

   Carrega_CustoRef;
   valor_custo := FValorizacaoAtividade.CalcularCustoAtividade(upag,UNID_PAG);

   if bolFin then
      begin
         if bolFinN4 and chkFin.Checked then
            begin
               TAL_EncerraF := TTAL_EncerraF.create( application );
               try
                  TAL_EncerraF.s          := edtSetO.Text;
                  TAL_EncerraF.f          := edtFazO.Text;
                  TAL_EncerraF.l          := edtLotO.Text;
                  TAL_EncerraF.t          := edtTalO.Text;
                  TAL_EncerraF.strCultura := GCultura;
                  TAL_EncerraF.FstrPlanta := GUsina;
                  TAL_EncerraF.StrIdCierre := 'PCORT';
                  TAL_EncerraF.OpenForm;

                  if not TAL_EncerraF.Encerra_COLHEITA(True, False, sMsg) then
                     begin
                        Exit;
                     end;

                  if Verificar_Processo_Ativo(Buscar_Processo_Interno('TAL_001')) then
                     ProcInterno_EncerramentoTalhao(edtSetO.Text,
                                                    edtFazO.Text,
                                                    edtLotO.Text,
                                                    edtTalO.Text,
                                                    ed_safra.Text);
               finally
                  Tal_EncerraF.Free;
               end;
            end;
      end;

   bNuevo := NuevoRegistro(GUsina, Num.Text);

   BasesF.GetConexionType.BeginTransaction;
   try
      if bNuevo then
         GuardaCambios_Acao(QQ, 'PLANTIO_CO', Num.Text, '', '', '', '', 'ADD');

       with QQ do
          begin
             Close;
             SQL.Text :=
               ' DELETE                  ' +
               '   FROM PLANTIO_CORTE_DISTRIB    ' +
               '  WHERE PLANTA = :PLANTA ' +
               '    AND NUMERO = :NUMERO ' ;
             ParamByName('PLANTA').AsString  := GUsina;
             ParamByName('NUMERO').AsInteger := Trunc(BConversao.MStrToFloat(num.Text));
             ExecSQL;

             Close;
             SQL.Text :=
               ' DELETE                  ' +
               '   FROM PLANTIO_CORTE    ' +
               '  WHERE PLANTA = :PLANTA ' +
               '    AND NUMERO = :NUMERO ' ;
             ParamByName('PLANTA').AsString  := GUsina;
             ParamByName('NUMERO').AsInteger := Trunc(BConversao.MStrToFloat(num.Text));
             ExecSQL;
             strsql := 'INSERT INTO PLANTIO_CORTE '+
                       ' ( PLANTA,                '+
                       '   NUMERO,                '+
                       '   SAFRA,                 '+
                       '   TEMPORADA,             '+
                       '   TIPO_CORTE,            '+
                       '   O_ESTAG,               '+
                       '   O_TOPOG,               '+
                       '   DATA,                  '+
                       '   LIB,                   '+
                       '   OS,                    '+
                       '   SETOR,                 '+
                       '   FAZ,                   '+
                       '   LOTE,                  '+
                       '   TAL,                   '+
                       '   OPER,                  '+
                       '   HORAFIN,               '+
                       '   OBSERV,                '+
                       '   NUM_PERSONAS,          '+
                       '   CJOPER,                '+
                       '   VARIEDADE,             '+
                       '   METROS,                '+
                       '   AREA,                  '+
                       '   CLIENTE,               '+
                       '   MESC,                  '+
                       '   TONELADAS,             '+
                       '   COMPRA,                '+
                       '   EMPRESA,               '+
                       '   FEIXES,                '+
                       '   PESO_FEIXE,            '+
                       '   CUSTO,                 '+
                       '   CUSTO_UN,              '+
                       '   FORNECEDOR,            '+
                       '   LATITUD,               '+
                       '   LONGITUD,              '+
                       '   DATA_EJECUCION,        '+
                       '   NUMERO_COL,            '+
                       '   TRATO,                 '+
                       '   IDADE )                '+
                       '  VALUES                  '+
                       ' ( :PLANTA,               '+
                       '   :NUMERO,               '+
                       '   :SAFRA,                '+
                       '   :TEMPORADA,            '+
                       '   :TIPO_CORTE,           '+
                       '   :O_ESTAG,              '+
                       '   :O_TOPOG,              '+
                       '   :DATA,                 '+
                       '   :LIB,                  '+
                       '   :OS,                   '+
                       '   :PSETOR,               '+
                       '   :FAZ,                  '+
                       '   :PLOTE,                '+
                       '   :TAL,                  '+
                       '   :OPER,                 '+
                       '   :HORAFIN,              '+
                       '   :OBSERV,               '+
                       '   :NUM_PERSONAS,         '+
                       '   :CJOPER,               '+
                       '   :VARIEDADE,            '+
                       '   :METROS,               '+
                       '   :AREA,                 '+
                       '   :CLIENTE,              '+
                       '   :MESC,                 '+
                       '   :TONELADAS,            '+
                       '   :COMPRA,               '+
                       '   :EMPRESA,              '+
                       '   :FEIXES,               '+
                       '   :PESO_FEIXE,           '+
                       '   :CUSTO,                '+
                       '   :CUSTO_UN,             '+
                       '   :FORNECEDOR,           '+
                       '   :LATITUD,              '+
                       '   :LONGITUD,             '+
                       '   :DATA_EJECUCION,       '+
                       '   :NUMERO_COL,           '+
                       '   :TRATO,                '+
                       '   :IDADE )               ';
             Close;
             SQL.Clear;
             SQL.Text := strsql;
             ParamByName('PLANTA'    ).AsString  := GUsina;
             ParamByName('NUMERO'    ).AsInteger := trunc(BConversao.MStrToFloat(num.Text));
             ParamByName('DATA'      ).AsDateTime    := datData.Date;
             if (not Dt_FH_Ejec.Visible) or (Dt_FH_Ejec.Date = 0)  then
                ParamByName('DATA_EJECUCION').AsDateTime := datData.Date
             else
                ParamByName('DATA_EJECUCION').AsDateTime := Dt_FH_Ejec.Date;
             ParamByName('SAFRA'     ).AsString  := ed_safra.Text;
             ParamByName('TEMPORADA' ).AsString  := Tempo;
             ParamByName('TIPO_CORTE').AsString  := TipoC;
             ParamByName('O_ESTAG'   ).AsString  := estag;
             ParamByName('O_TOPOG'   ).AsString  := topog;
             ParamByName('MESC'      ).AsString  := DimeMes(datData.Date);
             ParamByName('LIB'       ).AsString  := lib.text;
             ParamByName('OS'        ).AsFloat   := os.Valor;
             ParamByName('PSETOR'     ).AsString  := edtSetO.text;
             ParamByName('FAZ'       ).AsString  := edtFazO.text;
             ParamByName('PLOTE'      ).AsString  := edtLotO.text;
             ParamByName('TAL'       ).AsString  := edtTalO.text;
             ParamByName('OPER'      ).AsString  := oper.text;
             ParamByName('CJOPER'    ).AsString  := cjopered.text;
             ParamByName('VARIEDADE' ).AsString  := vared.text;
             ParamByName('CLIENTE'   ).AsString  := clienteed.text;
             ParamByName('METROS'    ).AsFloat   := BConversao.MStrToFloat(met.Text);
             ParamByName('AREA'      ).AsFloat   := BConversao.MStrToFloat(area.Text);
             ParamByName('OBSERV'    ).AsString   := edtOBS.Text;
             ParamByName('HORAFIN'   ).AsString   := edtHF.Text;
             ParamByName('NUM_PERSONAS').AsInteger:= BConversao.MStrToInt(NumPerEd.Text);
             ParamByName('TONELADAS' ).AsFloat   := BConversao.MStrToFloat(ton.Text);
             ParamByName('COMPRA'    ).AsInteger := Ord(chcompra.checked);
             ParamByName('FORNECEDOR').AsString  := forned.Text;
             ParamByName('EMPRESA'   ).AsString  := edtEmpresa.Text;
             ParamByName('FEIXES'    ).AsFloat   := BConversao.MStrToFloat(edtFeixes.Text);
             ParamByName('PESO_FEIXE').AsFloat   := BConversao.MStrToFloat(edtPeso_Feixe.Text);
             ParamByName('IDADE'     ).AsFloat   := Idade;
             ParamByName('CUSTO_UN'  ).AsFloat   := valor_custo;
             ParamByName('CUSTO'     ).AsFloat   := 0;
             if upag <> 0 then
                begin
                   case upag of
                      1 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(area.Text); //Hectareas
                      3 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(met.Text); //Metros
                      6 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(ton.Text); //Toneladas
                      8 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(edtFeixes.Text); //Feixes
                   end;
                end
             else
                begin
                   case Tipo_Valorizacao of
                       0 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(ton.Text); //Toneladas
                       1 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(edtFeixes.Text); //Feixes
                       2 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(met.Text); //Metros
                       3 : ParamByName('CUSTO').AsFloat := valor_custo * BConversao.MStrToFloat(area.Text); //Hectareas
                    end;
                end;
             ParamByName('LATITUD'    ).AsFloat  := BConversao.MStrToFloat( edtLat.text );
             ParamByName('LONGITUD'   ).AsFloat  := BConversao.MStrToFloat( edtLon.text );
             ParamByName('TRATO'      ).AsString := TratoEd.Text;
             ParamByName('NUMERO_COL' ).AsString := id_mobile;
             if id_mobile = '' then
                ParamByName('NUMERO_COL' ).Clear;
             ExecSQL;
          end;

      scodigo_processo := Buscar_Processo_Interno('PL_CORTE');
      if Verificar_Processo_Ativo(scodigo_processo) then
         begin
            lt_CDS:= TClientDataSet.Create(Application);
            try
               lt_CDS.FieldDefs.Clear;
               lt_CDS.FieldDefs.Add ( 'PLANTA',        ftString,  10, True);     // Planta
               lt_CDS.FieldDefs.Add ( 'OS',            ftFloat ,  0, True);     // Ordem de Serviço
               lt_CDS.FieldDefs.Add ( 'NUMERO',        ftFloat,   0,  True);     // Numero
               lt_CDS.CreateDataSet;

               lt_CDS.Append;
               lt_CDS.FieldByName('PLANTA'  ).AsString   := GUsina;
               lt_CDS.FieldByName('OS'      ).AsFloat   := os.Valor;
               lt_CDS.FieldByName('NUMERO'  ).AsFloat   := BConversao.MStrToFloat(num.Text);
               lt_CDS.Post;

               if not Executa_Processos_Internos( 'PL_CORTE' , lt_CDS, pErro) then
                  begin
                     if (Trim(pErro) <> '') then
                        begin
                           BMsg.Error(BMsg.Fix('Ocorreu um erro ao executar procedimento ',
                                               'Ocurrio error al ejecutar el procedimento  ',
                                               'A error happened executing the procedure ') + scodigo_processo + '-> ' + pErro);
                        end;
                     BasesF.GetConexionType.Rollback;
                     Exit;
                  end;
            finally
               if Assigned(lt_CDS) then
                  lt_CDS.Free;
            end;
         end;

      Grava_OS_Estado(nil, trunc(BConversao.MStrToFloat(num.Text)), oper.Text, -1, NomeUsuar + ' - PLANTIO Corte', datData.Date);

      Talhao_AtualizaAreaMuda(edtSetO.Text, edtFazO.Text, edtLotO.Text, edtTalO.Text);

      { Utilizado para gerar historico de ultima execução da atividade }
      TAL_GuardaOperPlantio(trunc(BConversao.MStrToFloat(num.Text)), GUsina);
      TAL_AtualizaResumo;

      if bGeneraLog then
         if Not bNuevo then
            GuardaCambios_SIAGRI(Plantio_CorteF, NIL, 0, QQ, 'PLANTIO_CO', Num.Text, '');

      BasesF.GetConexionType.Commit;
   except
      BasesF.GetConexionType.Rollback;
      raise;
   end;

   Grava := true;
end;