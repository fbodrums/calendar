<select class="{{ $css }}" id="{{ $id }}" name="state">
    <option value="">Selecione uma UF</option>
    <option value="AC" {{ old('state') == 'AC' || $selected == 'AC'  ? 'selected' : '' }}>Acre</option>
    <option value="AL" {{ old('state') == 'AL' || $selected == 'AL' ? 'selected' : '' }}>Alagoas</option>
    <option value="AP" {{ old('state') == 'AP' || $selected == 'AP' ? 'selected' : '' }}>Amapá</option>
    <option value="AM" {{ old('state') == 'AM' || $selected == 'AM' ? 'selected' : '' }}>Amazonas</option>
    <option value="BA" {{ old('state') == 'BA' || $selected == 'BA' ? 'selected' : '' }}>Bahia</option>
    <option value="CE" {{ old('state') == 'CE' || $selected == 'CE' ? 'selected' : '' }}>Ceará</option>
    <option value="DF" {{ old('state') == 'DF' || $selected == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
    <option value="ES" {{ old('state') == 'ES' || $selected == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
    <option value="GO" {{ old('state') == 'GO' || $selected == 'GO' ? 'selected' : '' }}>Goiás</option>
    <option value="MA" {{ old('state') == 'MA' || $selected == 'MA' ? 'selected' : '' }}>Maranhão</option>
    <option value="MT" {{ old('state') == 'MT' || $selected == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
    <option value="MS" {{ old('state') == 'MS' || $selected == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
    <option value="MG" {{ old('state') == 'MG' || $selected == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
    <option value="PA" {{ old('state') == 'PA' || $selected == 'PA' ? 'selected' : '' }}>Pará</option>
    <option value="PB" {{ old('state') == 'PB' || $selected == 'PB' ? 'selected' : '' }}>Paraíba</option>
    <option value="PR" {{ old('state') == 'PR' || $selected == 'PR' ? 'selected' : '' }}>Paraná</option>
    <option value="PE" {{ old('state') == 'PE' || $selected == 'PE' ? 'selected' : '' }}>Pernambuco</option>
    <option value="PI" {{ old('state') == 'PI' || $selected == 'PI' ? 'selected' : '' }}>Piauí</option>
    <option value="RJ" {{ old('state') == 'RJ' || $selected == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
    <option value="RN" {{ old('state') == 'RN' || $selected == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
    <option value="RS" {{ old('state') == 'RS' || $selected == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
    <option value="RO" {{ old('state') == 'RO' || $selected == 'RO' ? 'selected' : '' }}>Rondônia</option>
    <option value="RR" {{ old('state') == 'RR' || $selected == 'RR' ? 'selected' : '' }}>Roraima</option>
    <option value="SC" {{ old('state') == 'SC' || $selected == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
    <option value="SP" {{ old('state') == 'SP' || $selected == 'SP' ? 'selected' : '' }}>São Paulo</option>
    <option value="SE" {{ old('state') == 'SE' || $selected == 'SE' ? 'selected' : '' }}>Sergipe</option>
    <option value="TO" {{ old('state') == 'TO' || $selected == 'TO' ? 'selected' : '' }}>Tocantins</option>
</select>
